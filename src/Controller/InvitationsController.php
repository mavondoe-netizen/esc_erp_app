<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

/**
 * Invitations Controller
 *
 * @property \App\Model\Table\InvitationsTable $Invitations
 */
class InvitationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Invitations->find()
            ->contain(['Companies', 'Roles']);
        $invitations = $this->paginate($query);

        $this->set(compact('invitations'));
    }

    /**
     * View method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invitation = $this->Invitations->get($id, contain: ['Companies', 'Roles']);
        $this->set(compact('invitation'));
    }

    public function add()
    {
        $invitation = $this->Invitations->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['token'] = Text::uuid();
            $data['status'] = 'pending';
            
            // Assume the user inviting others wants them in their own company
            try {
                $data['company_id'] = $this->request->getAttribute('identity')->get('company_id');
            } catch (\Exception $e) {
                // Ignore if no company_id is available on the identity object
            }

            $invitation = $this->Invitations->patchEntity($invitation, $data, [
                'accessibleFields' => ['email' => true, 'role_id' => true, 'token' => true, 'company_id' => true, 'status' => true]
            ]);

            if ($this->Invitations->save($invitation)) {
                $inviteLink = Router::url(['controller' => 'Users', 'action' => 'acceptInvite', $invitation->token], true);

                try {
                    $mailer = new Mailer('default');
                    $mailer->setTo($invitation->email)
                        ->setSubject('You have been invited to join the system')
                        ->deliver("You have been invited to join. Click here to accept the invitation and set your password: {$inviteLink}");
                    $this->Flash->success('Invitation sent successfully.');
                } catch (\Exception $e) {
                    $this->Flash->error('Invitation saved, but email failed to send.');
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invitation could not be saved. Please, try again.'));
        }
        $roles = $this->Invitations->Roles->find('list', limit: 200)->all();
         $companies = $this->Invitations->Companies->find('list', limit: 200)->all();
        $this->set(compact('invitation', 'roles', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invitation = $this->Invitations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invitation = $this->Invitations->patchEntity($invitation, $this->request->getData());
            if ($this->Invitations->save($invitation)) {
                $this->Flash->success(__('The invitation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invitation could not be saved. Please, try again.'));
        }
        $companies = $this->Invitations->Companies->find('list', limit: 200)->all();
        $roles = $this->Invitations->Roles->find('list', limit: 200)->all();
        $this->set(compact('invitation', 'companies', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invitation = $this->Invitations->get($id);
        if ($this->Invitations->delete($invitation)) {
            $this->Flash->success(__('The invitation has been deleted.'));
        } else {
            $this->Flash->error(__('The invitation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
