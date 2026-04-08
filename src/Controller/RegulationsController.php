<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Regulations Controller
 *
 * @property \App\Model\Table\RegulationsTable $Regulations
 */
class RegulationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Regulations->find()
            ->contain(['Companies']);
        $regulations = $this->paginate($query);

        $this->set(compact('regulations'));
    }

    /**
     * View method
     *
     * @param string|null $id Regulation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $regulation = $this->Regulations->get($id, contain: ['Companies', 'ComplianceObligations']);
        $this->set(compact('regulation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $regulation = $this->Regulations->newEmptyEntity();
        if ($this->request->is('post')) {
            $regulation = $this->Regulations->patchEntity($regulation, $this->request->getData());
            if ($this->Regulations->save($regulation)) {
                $this->Flash->success(__('The regulation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The regulation could not be saved. Please, try again.'));
        }
        $companies = $this->Regulations->Companies->find('list', limit: 200)->all();
        $this->set(compact('regulation', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Regulation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $regulation = $this->Regulations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $regulation = $this->Regulations->patchEntity($regulation, $this->request->getData());
            if ($this->Regulations->save($regulation)) {
                $this->Flash->success(__('The regulation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The regulation could not be saved. Please, try again.'));
        }
        $companies = $this->Regulations->Companies->find('list', limit: 200)->all();
        $this->set(compact('regulation', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Regulation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $regulation = $this->Regulations->get($id);
        if ($this->Regulations->delete($regulation)) {
            $this->Flash->success(__('The regulation has been deleted.'));
        } else {
            $this->Flash->error(__('The regulation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
