<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Meetings Controller
 *
 * @property \App\Model\Table\MeetingsTable $Meetings
 */
class MeetingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Meetings')->find()
            ->contain(['Contacts', 'Users']);
        $meetings = $this->paginate($query);

        $this->set(compact('meetings'));
    }

    /**
     * View method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meeting = $this->fetchTable('Meetings')->get($id, contain: ['Contacts', 'Users']);
        $this->set(compact('meeting'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meeting = $this->fetchTable('Meetings')->newEmptyEntity();
        if ($this->request->is('post')) {
            $meeting = $this->fetchTable('Meetings')->patchEntity($meeting, $this->request->getData());
            if ($this->fetchTable('Meetings')->save($meeting)) {
                $this->Flash->success(__('The meeting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meeting could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Meetings')->Contacts->find('list', limit: 200)->all();
        $users = $this->fetchTable('Meetings')->Users->find('list', limit: 200)->all();
        $this->set(compact('meeting', 'contacts', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meeting = $this->fetchTable('Meetings')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meeting = $this->fetchTable('Meetings')->patchEntity($meeting, $this->request->getData());
            if ($this->fetchTable('Meetings')->save($meeting)) {
                $this->Flash->success(__('The meeting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meeting could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Meetings')->Contacts->find('list', limit: 200)->all();
        $users = $this->fetchTable('Meetings')->Users->find('list', limit: 200)->all();
        $this->set(compact('meeting', 'contacts', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Meeting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meeting = $this->fetchTable('Meetings')->get($id);
        if ($this->fetchTable('Meetings')->delete($meeting)) {
            $this->Flash->success(__('The meeting has been deleted.'));
        } else {
            $this->Flash->error(__('The meeting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
