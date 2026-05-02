<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tenders Controller
 *
 * @property \App\Model\Table\TendersTable $Tenders
 */
class TendersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Tenders->find()
            ->contain(['Procurements', 'Companies']);
        $tenders = $this->paginate($query);

        $this->set(compact('tenders'));
    }

    /**
     * View method
     *
     * @param string|null $id Tender id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tender = $this->Tenders->get($id, contain: ['Procurements', 'Companies', 'Awards', 'Evaluations', 'TenderBids']);
        $this->set(compact('tender'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tender = $this->Tenders->newEmptyEntity();
        if ($this->request->is('post')) {
            $tender = $this->Tenders->patchEntity($tender, $this->request->getData());
            if ($this->Tenders->save($tender)) {
                $this->Flash->success(__('The tender has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tender could not be saved. Please, try again.'));
        }
        $procurements = $this->Tenders->Procurements->find('list', limit: 200)->all();
        $companies = $this->Tenders->Companies->find('list', limit: 200)->all();
        $this->set(compact('tender', 'procurements', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tender id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tender = $this->Tenders->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tender = $this->Tenders->patchEntity($tender, $this->request->getData());
            if ($this->Tenders->save($tender)) {
                $this->Flash->success(__('The tender has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tender could not be saved. Please, try again.'));
        }
        $procurements = $this->Tenders->Procurements->find('list', limit: 200)->all();
        $companies = $this->Tenders->Companies->find('list', limit: 200)->all();
        $this->set(compact('tender', 'procurements', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tender id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tender = $this->Tenders->get($id);
        if ($this->Tenders->delete($tender)) {
            $this->Flash->success(__('The tender has been deleted.'));
        } else {
            $this->Flash->error(__('The tender could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
