<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Deals Controller
 *
 * @property \App\Model\Table\DealsTable $Deals
 */
class DealsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Deals->find()
            ->contain(['Contacts']);
        $deals = $this->paginate($query);

        $this->set(compact('deals'));
    }

    /**
     * View method
     *
     * @param string|null $id Deal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deal = $this->Deals->get($id, contain: ['Contacts']);
        $this->set(compact('deal'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deal = $this->Deals->newEmptyEntity();
        if ($this->request->is('post')) {
            $deal = $this->Deals->patchEntity($deal, $this->request->getData());
            if ($this->Deals->save($deal)) {
                $this->Flash->success(__('The deal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal could not be saved. Please, try again.'));
        }
        $companyId = $this->request->getAttribute('company_id');

        $contacts = $this->Deals->Contacts->find('list', limit: 200)
            ->where(['Contacts.company_id' => $companyId])
            ->all();
            
        $this->set(compact('deal', 'contacts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Deal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deal = $this->Deals->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deal = $this->Deals->patchEntity($deal, $this->request->getData());
            if ($this->Deals->save($deal)) {
                $this->Flash->success(__('The deal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal could not be saved. Please, try again.'));
        }
        $companyId = $this->request->getAttribute('company_id');

        $contacts = $this->Deals->Contacts->find('list', limit: 200)
            ->where(['Contacts.company_id' => $companyId])
            ->all();
            
        $this->set(compact('deal', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Deal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deal = $this->Deals->get($id);
        if ($this->Deals->delete($deal)) {
            $this->Flash->success(__('The deal has been deleted.'));
        } else {
            $this->Flash->error(__('The deal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
