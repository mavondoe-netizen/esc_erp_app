<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TaxTables Controller
 *
 * @property \App\Model\Table\TaxTablesTable $TaxTables
 */
class TaxTablesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TaxTables->find();
        $taxTables = $this->paginate($query);

        $this->set(compact('taxTables'));
    }

    /**
     * View method
     *
     * @param string|null $id Tax Table id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taxTable = $this->TaxTables->get($id, contain: []);
        $this->set(compact('taxTable'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taxTable = $this->TaxTables->newEmptyEntity();
        if ($this->request->is('post')) {
            $taxTable = $this->TaxTables->patchEntity($taxTable, $this->request->getData());
            if ($this->TaxTables->save($taxTable)) {
                $this->Flash->success(__('The tax table has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tax table could not be saved. Please, try again.'));
        }
        $this->set(compact('taxTable'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tax Table id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taxTable = $this->TaxTables->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taxTable = $this->TaxTables->patchEntity($taxTable, $this->request->getData());
            if ($this->TaxTables->save($taxTable)) {
                $this->Flash->success(__('The tax table has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tax table could not be saved. Please, try again.'));
        }
        $this->set(compact('taxTable'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tax Table id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $taxTable = $this->TaxTables->get($id);
        if ($this->TaxTables->delete($taxTable)) {
            $this->Flash->success(__('The tax table has been deleted.'));
        } else {
            $this->Flash->error(__('The tax table could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
