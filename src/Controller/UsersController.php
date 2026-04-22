<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * Authentication (login/logout/register), profile management,
 * company-switching for super-admins, and invitation acceptance.
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'register', 'acceptInvite']);
    }

    // -----------------------------------------------------------------------
    // LOGIN
    // -----------------------------------------------------------------------

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $redirect = $this->Authentication->getLoginRedirect() ?? ['controller' => 'Dashboard', 'action' => 'index'];
            return $this->redirect($redirect);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid email or password. Please try again.'));
        }
    }

    // -----------------------------------------------------------------------
    // LOGOUT
    // -----------------------------------------------------------------------

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // -----------------------------------------------------------------------
    // REGISTER
    // -----------------------------------------------------------------------

    public function register()
    {
        $Users = $this->fetchTable('Users');
        $user  = $Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Hash password
            if (!empty($data['password'])) {
                $data['password'] = (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['password']);
            }
            $data['role_id'] = $data['role_id'] ?? null;

            $user = $Users->patchEntity($user, $data);

            if ($Users->save($user)) {
                $this->Flash->success('Account created successfully. Please log in.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Could not create account. Please check for errors.');
        }

        $Companies = $this->fetchTable('Companies');
        $companies = $Companies->find('list', keyField: 'id', valueField: 'name')->all();
        $this->set(compact('user', 'companies'));
    }

    // -----------------------------------------------------------------------
    // INDEX (admin)
    // -----------------------------------------------------------------------

    public function index()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = $user->get('company_id');

        $Users = $this->fetchTable('Users');
        $query = $Users->find()
            ->contain(['Roles', 'Companies'])
            ->order(['Users.email' => 'ASC']);

        $users = $this->paginate($query, ['limit' => 50]);
        $this->set(compact('users'));
    }

    // -----------------------------------------------------------------------
    // VIEW
    // -----------------------------------------------------------------------

    public function view(int $id)
    {
        $Users = $this->fetchTable('Users');
        $viewUser = $Users->get($id, contain: ['Roles', 'Companies', 'Employees']);
        $this->set('viewUser', $viewUser);
    }

    // -----------------------------------------------------------------------
    // ADD
    // -----------------------------------------------------------------------

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Users = $this->fetchTable('Users');
        $user  = $Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;

            if (!empty($data['password'])) {
                $data['password'] = (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['password']);
            }

            $user = $Users->patchEntity($user, $data);

            if ($this->request->getQuery('popup')) {
                if ($Users->save($user)) {
                    $this->set('popupResult', ['id' => $user->id, 'name' => $user->name ?? $user->email]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Users->save($user)) {
                $this->Flash->success(__('User created.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not create user. Please check the form.'));
        }

        $Roles     = $this->fetchTable('Roles');
        $roles     = $Roles->find('list', keyField: 'id', valueField: 'name')
            ->where(['Roles.company_id' => $companyId])
            ->all();

        $Employees = $this->fetchTable('Employees');
        $employees = $Employees->find('list', keyField: 'id', valueField: 'name')
            ->where(['Employees.company_id' => $companyId])
            ->all();

        $companies = null;
        if ($this->viewVars['isSuperAdmin'] ?? false) {
            $companies = $this->fetchTable('Companies')->find('list')->all();
        }

        $this->set(compact('user', 'roles', 'employees', 'companies'));
    }

    // -----------------------------------------------------------------------
    // EDIT
    // -----------------------------------------------------------------------

    public function edit(int $id)
    {
        $Users = $this->fetchTable('Users');
        $user  = $Users->get($id);

        $companyId = $this->request->getAttribute('company_id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Only re-hash if a new password was typed
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['password']);
            }

            $user = $Users->patchEntity($user, $data);
            if ($Users->save($user)) {
                $this->Flash->success(__('User updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update user.'));
        }

        $Roles     = $this->fetchTable('Roles');
        $roles     = $Roles->find('list', keyField: 'id', valueField: 'name')
            ->where(['Roles.company_id' => $companyId])
            ->all();

        $Employees = $this->fetchTable('Employees');
        $employees = $Employees->find('list', keyField: 'id', valueField: 'name')
            ->where(['Employees.company_id' => $companyId])
            ->all();

        $companies = null;
        if ($this->viewVars['isSuperAdmin'] ?? false) {
            $companies = $this->fetchTable('Companies')->find('list')->all();
        }

        $this->set(compact('user', 'roles', 'employees', 'companies'));
    }

    // -----------------------------------------------------------------------
    // DELETE
    // -----------------------------------------------------------------------

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $Users = $this->fetchTable('Users');
        $user  = $Users->get($id);

        if ($Users->delete($user)) {
            $this->Flash->success(__('User deleted.'));
        } else {
            $this->Flash->error(__('Could not delete user.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // -----------------------------------------------------------------------
    // SWITCH COMPANY (super-admin) — session-only, no DB mutation
    // -----------------------------------------------------------------------

    /**
     * POST /users/switch-company
     *
     * Stores the target company_id in the session.
     * AppController reads it on every request and writes it to
     * Configure::write('Tenant.company_id') so TenantAwareBehavior
     * transparently scopes all ORM queries to the switched company.
     *
     * The authenticated user record is NEVER modified.
     *
     * @return \Cake\Http\Response|null
     */
    public function switchCompany()
    {
        $this->request->allowMethod(['post']);
        $authUser  = $this->Authentication->getIdentity();
        $session   = $this->request->getSession();

        // Super-admin: company_id = 1, role_id = 3 (Super Admin), or specific email
        $isSuperAdmin = (
            (int)$authUser->get('company_id') === 1 ||
            (int)$authUser->get('role_id') === 3 ||
            strtolower((string)($authUser->get('email') ?? '')) === 'tasara@gmail.com'
        );

        if (!$isSuperAdmin) {
            $this->Flash->error('You do not have permission to switch companies.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $targetId = (int)$this->request->getData('company_id');
        $Companies = $this->fetchTable('Companies');
        $company   = $Companies->find()
            ->select(['id', 'name'])
            ->where(['id' => $targetId])
            ->applyOptions(['ignoreTenant' => true])
            ->first();

        if (!$company) {
            $this->Flash->error('Company not found.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        // Write switch into session — AppController picks this up automatically
        $session->write('SuperAdmin.switched_company_id', $targetId);
        $session->write('SuperAdmin.active', true);

        $this->Flash->success("Now viewing as: {$company->name}. Your account has not been changed.");
        return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

    /**
     * POST /users/exit-company-switch
     * Clears the session switch — restores the super-admin's own company context.
     *
     * @return \Cake\Http\Response|null
     */
    public function exitCompanySwitch()
    {
        $this->request->allowMethod(['post']);
        $session = $this->request->getSession();

        $session->delete('SuperAdmin.switched_company_id');
        $session->delete('SuperAdmin.active');

        $this->Flash->success('Exited company view. Back to your own company.');
        return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

    // -----------------------------------------------------------------------
    // ACCEPT INVITATION
    // -----------------------------------------------------------------------

    /**
     * GET/POST /users/accept-invite/{token}
     * Allows an invited user to set up their password and activate account.
     *
     * @param string $token Invitation token.
     * @return \Cake\Http\Response|null
     */
    public function acceptInvite(string $token)
    {
        $Invitations = $this->fetchTable('Invitations');
        $invitation  = $Invitations->find()
            ->where(['Invitations.token' => $token, 'Invitations.used' => 0])
            ->first();

        if (!$invitation) {
            $this->Flash->error('Invalid or expired invitation link.');
            return $this->redirect(['action' => 'login']);
        }

        $Users = $this->fetchTable('Users');
        $user  = $Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['email']      = $invitation->email;
            $data['company_id'] = $invitation->company_id;
            $data['role_id']    = $invitation->role_id ?? null;

            if (!empty($data['password'])) {
                $data['password'] = (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['password']);
            }

            $user = $Users->patchEntity($user, $data);
            if ($Users->save($user)) {
                // Mark invitation as used
                $invitation->used = 1;
                $Invitations->save($invitation);

                $this->Flash->success('Account activated! Please log in.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Could not activate account. Please check for errors.');
        }

        $this->set(compact('invitation', 'user'));
    }
}
