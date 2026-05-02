<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use App\Controller\Traits\ImportExportTrait;

/**
 * Application Controller
 *
 * Handles authentication enforcement, tenant isolation, and layout helpers.
 *
 * TENANT ISOLATION
 * ─────────────────
 * The active company_id is resolved in this priority order:
 *   1. Session key  'Auth.switched_company_id'  (set when a super-admin switches company)
 *   2. The authenticated user's own company_id
 *
 * Once resolved it is written to Configure::write('Tenant.company_id', $id)
 * so that TenantAwareBehavior can enforce it on every ORM query/save transparently.
 */
class AppController extends Controller
{
    use ImportExportTrait;

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    // -----------------------------------------------------------------------
    // BEFORE FILTER — auth + tenant isolation
    // -----------------------------------------------------------------------

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $controller = $this->request->getParam('controller');
        $action     = $this->request->getParam('action');

        // Public actions — skip auth and tenant setup entirely
        $publicActions = ['login', 'logout', 'register', 'forgotPassword', 'resetPassword', 'acceptInvite'];
        if ($controller === 'Users' && in_array($action, $publicActions, true)) {
            $this->Authentication->allowUnauthenticated([$action]);
            return;
        }
        if ($controller === 'Pages') {
            $this->Authentication->allowUnauthenticated(['display', 'home']);
            return;
        }

        // Require authentication
        $result = $this->Authentication->getResult();
        if (!$result->isValid()) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // ── Tenant resolution ──────────────────────────────────────────────
        $user      = $this->Authentication->getIdentity();
        $session   = $this->request->getSession();

        $realCompanyId = (int)$user->get('company_id');

        // Super-admin: company_id = 1, role_id = 3 (Super Admin), or specific email
        $isSuperAdmin = (
            $realCompanyId === 1 ||
            (int)$user->get('role_id') === 3 ||
            strtolower((string)($user->get('email') ?? '')) === 'tasara@gmail.com'
        );

        // Session-based company switch (no DB mutation)
        $switchedId = (int)$session->read('SuperAdmin.switched_company_id');
        $isSwitched = $isSuperAdmin && $switchedId > 0 && $session->read('SuperAdmin.active');
        $companyId  = $isSwitched ? $switchedId : $realCompanyId;

        // Write to Configure — TenantAwareBehavior reads this on every ORM call
        Configure::write('Tenant.company_id', $companyId);

        // ── View variables ─────────────────────────────────────────────────
        $this->request = $this->request->withAttribute('company_id', $companyId);
        $this->set('currentCompanyId',     $companyId);
        $this->set('currentUser',          $user);
        $this->set('isSuperAdmin',         $isSuperAdmin);        // used by layout navbar switcher
        $this->set('isSuperAdminSwitched', $isSwitched);
        $this->set('switchedCompanyId',    $isSwitched ? $switchedId : null);  // layout banner check
        $this->set('realCompanyId',        $realCompanyId);
        $this->set('isAdminOrSuper',       $isSuperAdmin);
        $this->set('sandboxModeActive',    (bool)$session->read('Sandbox.active'));

        // Company name for the "Viewing as" banner
        if ($isSwitched) {
            $company = $this->fetchTable('Companies')
                ->find()->select(['id', 'name'])->where(['id' => $companyId])->first();
            $this->set('switchedCompanyName', $company ? $company->name : "Company #{$companyId}");
        }

        // Full company list for the navbar switcher dropdown (super-admin only)
        if ($isSuperAdmin) {
            $allCompanies = $this->fetchTable('Companies')
                ->find('all', ignoreTenant: true)
                ->select(['id', 'name'])
                ->order(['Companies.name'])
                ->all()
                ->toList();
            $this->set('allCompanies', $allCompanies);
        }
    }

    // -----------------------------------------------------------------------
    // BEFORE RENDER — popup layout
    // -----------------------------------------------------------------------

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        $controller = $this->request->getParam('controller');
        $action     = $this->request->getParam('action');

        if ($this->request->getQuery('popup')) {
            $this->viewBuilder()->setLayout('popup');
        } elseif ($controller === 'Users' && in_array($action, ['login', 'register'])) {
            $this->viewBuilder()->setLayout('login');
        }
    }

    /**
     * Get ZIMRA options for earnings and deductions mappings.
     *
     * @return array
     */
    protected function getZimraOptions(): array
    {
        $options = [
            'Current Salary, wages, fees, Commissions etc (regular earnings) USD',
            'Current Salary, wages, fees, Commissions etc (regular earnings) ZWG',
            'Other Exemptions on Current Salary, Wages, Fees, Commissions Etc (Regular Earnings) USD',
            'Other Exemptions on Current Salary, Wages, Fees, Commissions Etc (Regular Earnings) ZWG',
            'Current Overtime USD',
            'Current Overtime ZWG',
            'Current Bonus USD',
            'Current Bonus ZWG',
            'Current Irregular Commission USD',
            'Current Irregular Commission ZWG',
            'Current Other Irregular earnings USD',
            'Current Other Irregular earnings ZWG',
            'Current Severance pay, gratuity or similar benefit, on retrenchment (with exemption) USD',
            'Current Severance pay, gratuity or similar benefit, on retrenchment (with exemption) ZWG',
            'Current Gratuity without exemption USD',
            'Current Gratuity without exemption ZWG',
            'Current Housing Benefit USD',
            'Current Housing Benefit ZWG',
            'Current Vehicle Benefit USD',
            'Current Vehicle Benefit ZWG',
            'Current Education Benefit USD',
            'Current Education Benefit ZWG',
            'Current Other Benefits USD',
            'Current Other Benefits ZWG',
            'Current Non-Taxable Earnings USD',
            'Current Non-taxable earnings ZWG',
            'Current Pension Contributions USD',
            'Current Pension Contributions ZWG',
            'Current NSSA Contributions USD',
            'Current NSSA Contributions ZWG',
            'Current Retirement Annuity Fund Contributions USD',
            'Current Retirement Annuity Fund Contributions ZWG',
            'Current NEC/Subscriptions USD',
            'Current NEC/Subscriptions ZWG',
            'Current Other Deductions USD',
            'Current Other Deductions ZWG',
            'Current Medical Aid Contributions USD',
            'Current Medical Aid Contributions ZWG',
            'Current Medical Expenses USD',
            'Current Medical Expenses ZWG',
            'Current Blind persons credit USD',
            'Current Blind persons credit ZWG',
            'Current Disabled persons credit USD',
            'Current Disabled persons credit ZWG',
            'Current Elderly person credit USD',
            'Current Elderly person credit ZWG',
            'Cumulative Bonus (from last tax period) USD',
            'Cumulative Bonus (from last tax period) ZWG'
        ];

        return array_combine($options, $options);
    }
}
