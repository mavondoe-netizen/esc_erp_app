<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Increase pagination limits massively so DataTables can operate globally
     */
    protected array $paginate = [
        'limit' => 5000,
        'maxLimit' => 10000,
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
         $this->loadComponent('Authentication.Authentication');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Do not check permissions on login, logout, home, or super-admin utility actions
        $action = strtolower($this->request->getParam('action'));
        $controller = $this->getName();
        if (in_array($action, ['login', 'logout', 'register', 'display', 'switchcompany', 'exitcompanyswitch'])
            || $controller === 'Pages'
            || $controller === 'Search') {
            return;
        }

        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return;
        }

        // --- MULTI-TENANCY INJECTION ---
        // Check if this is a super admin who has switched into another company's context
        $superAdminSwitchedId = $this->request->getSession()->read('SuperAdmin.switched_company_id');
        $isSuperAdminRole = false;
        $cachedRole = null;
        try {
            $cachedRole = $this->fetchTable('Roles')->get($identity->role_id);
            $isSuperAdminRole = in_array(strtolower($cachedRole->get('name')), ['super admin', 'super administrator']);
        } catch (\Exception $e) { }

        if ($isSuperAdminRole && $superAdminSwitchedId) {
            // Super admin is viewing a specific tenant company
            \Cake\Core\Configure::write('Tenant.company_id', $superAdminSwitchedId);
        } elseif (isset($identity->company_id) && $identity->company_id) {
            // Normal user — scope to their own company
            \Cake\Core\Configure::write('Tenant.company_id', $identity->company_id);
        }

        // --- LICENSE ENFORCEMENT GUARD ---
        if ($activeCompanyId = \Cake\Core\Configure::read('Tenant.company_id')) {
            try {
                // Determine if we need to enforce license rules.
                // Exclude the Super Admin managing companies, and basic User auth endpoints
                if (!($isSuperAdminRole && $controller === 'Companies') && $controller !== 'Users') {
                    // Temporarily disable TenantAware to fetch the company record directly if needed, 
                    // or just fetch since we are searching by primary key
                    $company = $this->fetchTable('Companies')->get($activeCompanyId);
                    
                    if ($company->license_expiry_date) {
                        $now = new \Cake\I18n\FrozenDate();
                        $expiry = new \Cake\I18n\FrozenDate($company->license_expiry_date);
                        $daysLeft = $now->diffInDays($expiry, false); // false = negative if in past
                        
                        if ($daysLeft < 0) { // License is expired
                            // Only block POST/PUT/PATCH/DELETE (postings stop)
                            if ($this->request->is(['post', 'put', 'patch', 'delete'])) {
                                if ($this->request->is('ajax')) {
                                    return $this->response->withStatus(403)
                                        ->withStringBody(json_encode(['success' => false, 'message' => 'Your company license has expired. Postings are disabled. Please contact your administrator.']));
                                } else {
                                    $this->Flash->error(__('Your company license has expired. Postings are disabled. Please contact your administrator.'));
                                    return $this->redirect($this->referer(['controller' => 'Pages', 'action' => 'display', 'home']));
                                }
                            }
                        } elseif ($daysLeft <= 30) {
                            // Soft Grace Period / Warning
                            $this->Flash->warning(__('Your company license will expire in {0} days. Please renew to avoid disruption to postings.', $daysLeft));
                        }
                    }
                }
            } catch (\Exception $e) {
                // Ignore gracefully if company metadata missing
            }
        }

        // Bypass permissions for Admins and Super Admins entirely to prevent lockout
        // Re-use the already-fetched role to avoid a second DB hit
        $isAdminOrSuper = false;
        try {
            $roleName = $cachedRole ? strtolower($cachedRole->get('name')) : '';
            if (!$roleName && isset($identity->role_id)) {
                $cachedRole = $this->fetchTable('Roles')->get($identity->role_id);
                $roleName = strtolower($cachedRole->get('name'));
            }
            $isAdminOrSuper = in_array($roleName, ['manager', 'super admin', 'administrator', 'super administrator']);
        } catch (\Exception $e) { }

        if ($isAdminOrSuper) {
            return;
        }

        // Determine CRUD capability needed based on the requested controller action
        $requiredCapability = null;
        switch ($action) {
            case 'index':
            case 'view':
                $requiredCapability = 'can_read';
                break;
            case 'add':
                $requiredCapability = 'can_create';
                break;
            case 'edit':
                $requiredCapability = 'can_update';
                break;
            case 'delete':
                $requiredCapability = 'can_delete';
                break;
            case 'approve':
            case 'reject':
                $requiredCapability = 'can_approve';
                break;
        }

        if ($requiredCapability) {
            // Find specific permission matching role and model
            $permission = $this->fetchTable('Permissions')->find()
                ->where([
                    'role_id' => $identity->role_id,
                    'model' => $controller
                ])
                ->first();

            // If no permission rule exists, or the specific capability is false: block them
            if (!$permission || !$permission->{$requiredCapability}) {
                $this->Flash->error(__("Access Denied: You do not have '{0}' permission for {1}. Please contact an Administrator.", $requiredCapability, $controller));
                return $this->redirect('/');
            }
        }
    }

    
    public function isAdmin()
    {
        return $this->request->getAttribute('identity')->role_id == 3;
    }

    public function isApprover()
    {
        return $this->request->getAttribute('identity')->role_id == 2;
    }

    public function isUser()
    {
        return $this->request->getAttribute('identity')->role_id == 1;
    }
    
    public function isManager()
    {
        return $this->request->getAttribute('identity')->role_id == 4;
    }

    /**
     * Returns true if the logged-in user has the 'Employee' portal role.
     */
    public function isEmployee(): bool
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) return false;
        try {
            $role = $this->fetchTable('Roles')->get($identity->role_id);
            return strtolower($role->get('name')) === 'employee';
        } catch (\Exception $e) {
            return false;
        }
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        parent::beforeRender($event);

        $identity = $this->request->getAttribute('identity');
        $isAdminOrSuper = false;
        $isSuperAdmin = false;
        $allCompanies = [];
        $switchedCompanyId = null;
        $switchedCompanyName = null;
        
        if ($identity && isset($identity->role_id)) {
            try {
                $role = $this->fetchTable('Roles')->get($identity->role_id);
                $roleName = strtolower($role->get('name'));
                $isAdminOrSuper = in_array($roleName, ['manager', 'super admin', 'administrator', 'super administrator']);
                $isSuperAdmin = in_array($roleName, ['super admin', 'super administrator']);
            } catch (\Exception $e) {
                $isAdminOrSuper = false;
            }

            // Super admin gets a list of all companies to switch between
            if ($isSuperAdmin) {
                try {
                    // Use raw DB connection to bypass TenantAware behavior and get ALL companies
                    $conn = $this->fetchTable('Companies')->getConnection();
                    $result = $conn->execute('SELECT id, name FROM companies ORDER BY name ASC')->fetchAll('assoc');
                    $allCompanies = $result ?: [];
                } catch (\Exception $e) {
                    $allCompanies = [];
                }
                $switchedCompanyId = $this->request->getSession()->read('SuperAdmin.switched_company_id');
                if ($switchedCompanyId) {
                    foreach ($allCompanies as $co) {
                        if (is_object($co) && $co->id == $switchedCompanyId) {
                            $switchedCompanyName = $co->name;
                            break;
                        } elseif (is_array($co) && ($co['id'] ?? null) == $switchedCompanyId) {
                            $switchedCompanyName = $co['name'];
                            break;
                        }
                    }
                    // Fallback for list format (id => name)
                    if (!$switchedCompanyName && isset($allCompanies[$switchedCompanyId])) {
                        $switchedCompanyName = $allCompanies[$switchedCompanyId];
                    }
                }
            }
        }
        
        $this->set(compact('isAdminOrSuper', 'isSuperAdmin', 'allCompanies', 'switchedCompanyId', 'switchedCompanyName'));

        // Pass sandbox mode flag to all views so layout can show/hide the banner
        $sandboxModeActive = $this->request->getSession()->read('Sandbox.active', false);
        $this->set(compact('sandboxModeActive'));
    }

    /**
     * Global Generic CSV Import capabilities for all inheriting controllers
     */
    public function import()
    {
        $this->request->allowMethod(['post']);
        
        $file = $this->request->getData('import_file');
        if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
            return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Invalid or missing CSV file']));
        }

        $tmpName = $file->getStream()->getMetadata('uri');
        $csvData = array_map('str_getcsv', file($tmpName));
        
        if (empty($csvData)) {
            return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'CSV is empty']));
        }

        // Assume first row is headers (columns)
        $headers = array_shift($csvData);
        $modelName = $this->getName(); // e.g., 'Customers'
        
        try {
            $table = $this->fetchTable($modelName);
            $entities = [];
            
            foreach ($csvData as $row) {
                // Ensure row length matches headers
                if (count($row) !== count($headers)) continue;
                
                $data = array_combine($headers, $row);
                // Try to create entity
                $entities[] = $table->newEntity($data);
            }
            
            if ($table->saveMany($entities)) {
                $this->Flash->success(__('{0} records imported successfully.', count($entities)));
                return $this->response->withStatus(200)->withStringBody(json_encode(['status' => 'success']));
            } else {
                return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Failed to save imported rows. Check validation rules.']));
            }
        } catch (\Exception $e) {
            return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Server Error: ' . $e->getMessage()]));
        }
    }

    /**
     * AJAX Endpoint to identify bulk updatable fields for the current model
     */
    public function apiGetBulkOptions()
    {
        $this->request->allowMethod(['get', 'ajax']);
        $modelName = $this->getName();
        $table = $this->fetchTable($modelName);
        $schema = $table->getSchema();
        $columns = $schema->columns();
        
        $updatable = [];
        $skipFields = ['id', 'created', 'modified', 'company_id', 'employee_code', 'national_identity'];

        foreach ($columns as $col) {
            if (in_array($col, $skipFields)) continue;
            
            $columnInfo = $schema->getColumn($col);
            $type = $columnInfo['type'];
            
            // For bulk update, we only surface certain types or if a list of values exists
            // We can look for variables sent to the view in a standard Cake way (optional/manual)
            // But let's start with fields that are likely enums or simple strings/decimals
            if (in_array($type, ['string', 'decimal', 'boolean', 'integer', 'date'])) {
                $updatable[] = [
                    'field' => $col,
                    'label' => \Cake\Utility\Inflector::humanize($col),
                    'type' => $type
                ];
            }
        }
        
        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'fields' => $updatable]));
    }

    /**
     * AJAX Endpoint to handle bulk actions (Delete, Update)
     */
    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'ajax']);
        $data = $this->request->getData();
        $ids = $data['ids'] ?? [];
        $action = $data['action'] ?? '';
        
        if (empty($ids)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'No records selected.']));
        }

        $modelName = $this->getName();
        $table = $this->fetchTable($modelName);

        try {
            if ($action === 'delete') {
                $entities = $table->find()->where(['id IN' => $ids])->all();
                if ($table->deleteMany($entities)) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => true, 'message' => count($ids) . ' records deleted.']));
                }
            } elseif ($action === 'update') {
                $field = $data['field'] ?? '';
                $value = $data['value'] ?? null;
                
                if (!$field) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => false, 'message' => 'Field is required for update.']));
                }

                // If boolean, cast to proper type
                $schema = $table->getSchema()->getColumn($field);
                if ($schema && $schema['type'] === 'boolean') {
                    $value = (bool)$value;
                }

                $count = $table->updateAll([$field => $value], ['id IN' => $ids]);
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => true, 'message' => $count . ' records updated.']));
            }
        } catch (\Exception $e) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => $e->getMessage()]));
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => false, 'message' => 'Invalid action.']));
    }
}
