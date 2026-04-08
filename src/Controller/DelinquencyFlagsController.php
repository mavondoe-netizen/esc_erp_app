<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DelinquencyFlags Controller
 *
 * @property \App\Model\Table\DelinquencyFlagsTable $DelinquencyFlags
 */
class DelinquencyFlagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DelinquencyFlags->find()
            ->contain(['Loans']);
        $delinquencyFlags = $this->paginate($query);

        $this->set(compact('delinquencyFlags'));
    }

    /**
     * View method
     *
     * @param string|null $id Delinquency Flag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $delinquencyFlag = $this->DelinquencyFlags->get($id, contain: ['Loans']);
        $this->set(compact('delinquencyFlag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $delinquencyFlag = $this->DelinquencyFlags->newEmptyEntity();
        if ($this->request->is('post')) {
            $delinquencyFlag = $this->DelinquencyFlags->patchEntity($delinquencyFlag, $this->request->getData());
            if ($this->DelinquencyFlags->save($delinquencyFlag)) {
                $this->Flash->success(__('The delinquency flag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delinquency flag could not be saved. Please, try again.'));
        }
        $loans = $this->DelinquencyFlags->Loans->find('list', limit: 200)->all();
        $this->set(compact('delinquencyFlag', 'loans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delinquency Flag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $delinquencyFlag = $this->DelinquencyFlags->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $delinquencyFlag = $this->DelinquencyFlags->patchEntity($delinquencyFlag, $this->request->getData());
            if ($this->DelinquencyFlags->save($delinquencyFlag)) {
                $this->Flash->success(__('The delinquency flag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delinquency flag could not be saved. Please, try again.'));
        }
        $loans = $this->DelinquencyFlags->Loans->find('list', limit: 200)->all();
        $this->set(compact('delinquencyFlag', 'loans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delinquency Flag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $delinquencyFlag = $this->DelinquencyFlags->get($id);
        if ($this->DelinquencyFlags->delete($delinquencyFlag)) {
            $this->Flash->success(__('The delinquency flag has been deleted.'));
        } else {
            $this->Flash->error(__('The delinquency flag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
