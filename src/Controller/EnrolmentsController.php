<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Enrolments Controller
 *
 * @property \App\Model\Table\EnrolmentsTable $Enrolments
 */
class EnrolmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Enrolments')->find()
            ->contain(['Units']);
        $enrolments = $this->paginate($query);

        $this->set(compact('enrolments'));
    }

    /**
     * View method
     *
     * @param string|null $id Enrolment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enrolment = $this->fetchTable('Enrolments')->get($id, contain: ['Units']);
        $this->set(compact('enrolment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enrolment = $this->fetchTable('Enrolments')->newEmptyEntity();
        if ($this->request->is('post')) {
            $enrolment = $this->fetchTable('Enrolments')->patchEntity($enrolment, $this->request->getData());
            if ($this->fetchTable('Enrolments')->save($enrolment)) {
                $this->Flash->success(__('The enrolment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enrolment could not be saved. Please, try again.'));
        }
        $units = $this->fetchTable('Enrolments')->Units->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Enrolments')->Tenants->find('list', limit: 200)->all();
        $this->set(compact('enrolment', 'units', 'tenants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Enrolment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enrolment = $this->fetchTable('Enrolments')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enrolment = $this->fetchTable('Enrolments')->patchEntity($enrolment, $this->request->getData());
            if ($this->fetchTable('Enrolments')->save($enrolment)) {
                $this->Flash->success(__('The enrolment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enrolment could not be saved. Please, try again.'));
        }
        $units = $this->fetchTable('Enrolments')->Units->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Enrolments')->Tenants->find('list', limit: 200)->all();
        $this->set(compact('enrolment', 'units', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Enrolment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enrolment = $this->fetchTable('Enrolments')->get($id);
        if ($this->fetchTable('Enrolments')->delete($enrolment)) {
            $this->Flash->success(__('The enrolment has been deleted.'));
        } else {
            $this->Flash->error(__('The enrolment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
