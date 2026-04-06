<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Users')->find()
            ->contain(['Roles']);
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->fetchTable('Users')->get($id, contain: ['Meetings', 'Roles', 'Companies', 'Employees']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->fetchTable('Users')->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->fetchTable('Users')->patchEntity($user, $this->request->getData());
            if ($this->fetchTable('Users')->save($user)) {


                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->fetchTable('Users')->Roles->find('list', limit: 200)->all();
        $employees = $this->fetchTable('Employees')->find('list', [
            'keyField' => 'id',
            'valueField' => function($e) { return $e->get('first_name') . ' ' . $e->get('last_name') . ' (' . $e->get('employee_code') . ')'; }
        ])->all();
        $companies = $this->fetchTable('Users')->Companies->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles', 'employees', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->fetchTable('Users')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->fetchTable('Users')->patchEntity($user, $this->request->getData());
            if ($this->fetchTable('Users')->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->fetchTable('Users')->Roles->find('list', limit: 200)->all();
        $employees = $this->fetchTable('Employees')->find('list', [
            'keyField' => 'id',
            'valueField' => function($e) { return $e->get('first_name') . ' ' . $e->get('last_name') . ' (' . $e->get('employee_code') . ')'; }
        ])->all();
        $companies = $this->fetchTable('Users')->Companies->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles', 'employees', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->fetchTable('Users')->get($id);
        if ($this->fetchTable('Users')->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);
    $this->Authentication->addUnauthenticatedActions(['login', 'add', 'register', 'acceptInvite']);
}
public function login()
{
    $this->viewBuilder()->setLayout('login');
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();

    if ($result->isValid()) {
        $identity = $this->request->getAttribute('identity');

        // Redirect Employee-role users to the Self-Service Portal
        try {
            if ($identity && isset($identity->role_id)) {
                $role = $this->fetchTable('Roles')->get($identity->role_id);
                if (strtolower((string)$role->get('name')) === 'employee') {
                    return $this->redirect('/portal/dashboard');
                }
            }
        } catch (\Exception $e) { }

        $redirect = $this->request->getQuery('redirect', [
            'controller' => 'Customers',
            'action' => 'index',
        ]);
        return $this->redirect($redirect);
    }

    //if ($this->request->is('post') && !$result->isValid()) {
      //  $this->Flash->error('Invalid email or password');
    //}
   
}

public function logout()
{
    $this->Authentication->logout();
    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
}
public function register()
    {
        $user = $this->fetchTable('Users')->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->fetchTable('Users')->patchEntity($user, $this->request->getData());
            if ($this->fetchTable('Users')->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->fetchTable('Users')->Roles->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles'));
    }

    public function acceptInvite($token = null)
    {
        $this->viewBuilder()->setLayout('login'); // use simple layout for setting password
        $invitationsTable = $this->fetchTable('Invitations');
        $invitation = $invitationsTable->find()
            ->where(['token' => $token, 'status' => 'pending'])
            ->first();

        if (!$invitation) {
            $this->Flash->error('Invalid or expired invitation token.');
            return $this->redirect(['action' => 'login']);
        }

        $user = $this->fetchTable('Users')->newEmptyEntity();
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            // Force data from invitation
            $data['email'] = $invitation->email;
            $data['role_id'] = $invitation->role_id;
            $data['company_id'] = $invitation->company_id;

            $user = $this->fetchTable('Users')->patchEntity($user, $data);
            if ($this->fetchTable('Users')->save($user)) {
                
                // Mark invite accepted
                $invitation->status = 'accepted';
                $invitationsTable->save($invitation);

                $this->Flash->success('Your account has been created. You can now login.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Unable to create account. Please ensure your password matches requirements.');
        }

        $this->set(compact('user', 'invitation'));
    }

    /**
     * Super Admin: Switch the active tenant context to any company.
     * POST /users/switch-company
     */
    public function switchCompany()
    {
        $this->request->allowMethod(['post']);
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect('/');
        }

        // Verify the requesting user is a super admin
        $isSuperAdmin = false;
        try {
            $role = $this->fetchTable('Roles')->get($identity->role_id);
            $isSuperAdmin = in_array(strtolower($role->get('name')), ['super admin', 'super administrator']);
        } catch (\Exception $e) { }

        if (!$isSuperAdmin) {
            $this->Flash->error(__('Only Super Admins can switch companies.'));
            return $this->redirect($this->referer('/'));
        }

        $companyId = (int)$this->request->getData('company_id');
        if ($companyId) {
            $this->request->getSession()->write('SuperAdmin.switched_company_id', $companyId);
            // Get company name for feedback
            try {
                $conn = $this->fetchTable('Companies')->getConnection();
                $row = $conn->execute('SELECT name FROM companies WHERE id = ?', [$companyId])->fetch('assoc');
                $companyName = $row['name'] ?? 'Company #' . $companyId;
            } catch (\Exception $e) {
                $companyName = 'Company #' . $companyId;
            }
            $this->Flash->success(__("Now viewing as: {$companyName}"));
        } else {
            $this->Flash->error(__('Invalid company selected.'));
        }

        return $this->redirect($this->referer('/'));
    }

    /**
     * Super Admin: Exit company switch — revert to own context.
     * POST /users/exit-company-switch
     */
    public function exitCompanySwitch()
    {
        $this->request->allowMethod(['post']);
        $this->request->getSession()->delete('SuperAdmin.switched_company_id');
        $this->Flash->success(__('Returned to your own company context.'));
        return $this->redirect($this->referer('/'));
    }
}
