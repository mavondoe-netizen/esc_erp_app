<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Risks Controller
 *
 * @property \App\Model\Table\RisksTable $Risks
 */
class RisksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Risks->find()
            ->contain(['Companies']);
        $risks = $this->paginate($query);

        $this->set(compact('risks'));
    }

    /**
     * View method
     *
     * @param string|null $id Risk id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $risk = $this->Risks->get($id, contain: ['Companies', 'Controls', 'Kris', 'RiskAssessments']);
        $this->set(compact('risk'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $risk = $this->Risks->newEmptyEntity();
        if ($this->request->is('post')) {
            $risk = $this->Risks->patchEntity($risk, $this->request->getData());
            if ($this->Risks->save($risk)) {
                $this->Flash->success(__('The risk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The risk could not be saved. Please, try again.'));
        }
        $companies = $this->Risks->Companies->find('list', limit: 200)->all();
        $this->set(compact('risk', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Risk id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $risk = $this->Risks->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $risk = $this->Risks->patchEntity($risk, $this->request->getData());
            if ($this->Risks->save($risk)) {
                $this->Flash->success(__('The risk has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The risk could not be saved. Please, try again.'));
        }
        $companies = $this->Risks->Companies->find('list', limit: 200)->all();
        $this->set(compact('risk', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Risk id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $risk = $this->Risks->get($id);
        if ($this->Risks->delete($risk)) {
            $this->Flash->success(__('The risk has been deleted.'));
        } else {
            $this->Flash->error(__('The risk could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
