<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DealRequests Controller
 *
 * @property \App\Model\Table\DealRequestsTable $DealRequests
 */
class DealRequestsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['webhook']);

        // Bypass CSRF strictly for JSON payloads to the webhook action
        if ($this->request->getParam('action') === 'webhook') {
            $this->getEventManager()->off($this->Csrf);
        }
    }

    /**
     * Webhook Endpoint (No UI, JSON response)
     */
    public function webhook()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setOption('serialize', true);

        // Security via configured static token
        $secretKey = 'SECURE_WEBHOOK_KEY_123';
        $providedKey = $this->request->getQuery('token');

        if ($providedKey !== $secretKey) {
            return $this->response->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Unauthorized token']));
        }

        $data = $this->request->getData();
        $data['status'] = 'New';
        $data['source'] = $data['source'] ?? 'Webhook';

        $dealRequest = $this->DealRequests->newEmptyEntity();
        $dealRequest = $this->DealRequests->patchEntity($dealRequest, $data);

        if ($this->DealRequests->save($dealRequest)) {
            return $this->response->withStatus(200)
                ->withType('application/json')
                ->withStringBody(json_encode(['success' => true, 'id' => $dealRequest->id]));
        }

        return $this->response->withStatus(400)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Failed to save deal request', 'details' => $dealRequest->getErrors()]));
    }

    /**
     * Converts a request into a formal Contact and Deal
     */
    public function convert($id = null)
    {
        $this->request->allowMethod(['post']);
        $dealRequest = $this->DealRequests->get($id);

        if ($dealRequest->status === 'Converted' || !empty($dealRequest->deal_id)) {
            $this->Flash->error(__('This request has already been converted.'));
            return $this->redirect(['action' => 'index']);
        }

        $contactsTable = $this->fetchTable('Contacts');
        $dealsTable = $this->fetchTable('Deals');

        // Match existing contact intelligently
        $contact = $contactsTable->find()
            ->where(['email' => $dealRequest->email])
            ->first();

        if (!$contact) {
            // Create a brand new mapped contact
            $contact = $contactsTable->newEntity([
                'name' => trim(($dealRequest->first_name ?? '') . ' ' . ($dealRequest->last_name ?? '')),
                'email' => $dealRequest->email,
                'mobile' => $dealRequest->phone ?? 'N/A',
                'company_id' => $dealRequest->company_id,
            ]);
            $contactsTable->save($contact);
        }

        if ($contact && $contact->id) {
            $dealNamePrefix = $dealRequest->company_name ? "Deal: {$dealRequest->company_name}" : "New Deal";
            $deal = $dealsTable->newEntity([
                'name' => $dealNamePrefix,
                'description' => "Source: {$dealRequest->source}\n\nMessage: {$dealRequest->message}",
                'date' => date('Y-m-d'),
                'type' => 'B2B', // Arbitrary default, can be edited
                'value' => 0,
                'stage' => 'Discovery', // Automatically start at Discovery
                'contact_id' => $contact->id,
                'company_id' => $dealRequest->company_id,
                'status' => 'Draft' // Requires user mapping before initializing workflow
            ]);

            if ($dealsTable->save($deal)) {
                // Lock the request
                $dealRequest->status = 'Converted';
                $dealRequest->deal_id = $deal->id;
                $this->DealRequests->save($dealRequest);

                $this->Flash->success(__('Request converted successfully! Please finalize the deal.'));
                return $this->redirect(['controller' => 'Deals', 'action' => 'edit', $deal->id]);
            }
        }

        $this->Flash->error(__('Failed to convert the request.'));
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DealRequests->find()
            ->contain(['Companies', 'Deals']);
        $dealRequests = $this->paginate($query);

        $this->set(compact('dealRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dealRequest = $this->DealRequests->get($id, contain: ['Companies', 'Deals']);
        $this->set(compact('dealRequest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dealRequest = $this->DealRequests->newEmptyEntity();
        if ($this->request->is('post')) {
            $dealRequest = $this->DealRequests->patchEntity($dealRequest, $this->request->getData());
            if ($this->DealRequests->save($dealRequest)) {
                $this->Flash->success(__('The deal request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal request could not be saved. Please, try again.'));
        }
        $companies = $this->DealRequests->Companies->find('list', limit: 200)->all();
        $deals = $this->DealRequests->Deals->find('list', limit: 200)->all();
        $statuses = ['New' => 'New', 'Contacted' => 'Contacted', 'Qualified' => 'Qualified', 'Converted' => 'Converted', 'Rejected' => 'Rejected'];
        $sources = ['Webhook' => 'Webhook', 'Website' => 'Website', 'Manual' => 'Manual', 'Referral' => 'Referral', 'Other' => 'Other'];
        $this->set(compact('dealRequest', 'companies', 'deals', 'statuses', 'sources'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dealRequest = $this->DealRequests->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dealRequest = $this->DealRequests->patchEntity($dealRequest, $this->request->getData());
            if ($this->DealRequests->save($dealRequest)) {
                $this->Flash->success(__('The deal request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal request could not be saved. Please, try again.'));
        }
        $companies = $this->DealRequests->Companies->find('list', limit: 200)->all();
        $deals = $this->DealRequests->Deals->find('list', limit: 200)->all();
        $statuses = ['New' => 'New', 'Contacted' => 'Contacted', 'Qualified' => 'Qualified', 'Converted' => 'Converted', 'Rejected' => 'Rejected'];
        $sources = ['Webhook' => 'Webhook', 'Website' => 'Website', 'Manual' => 'Manual', 'Referral' => 'Referral', 'Other' => 'Other'];
        $this->set(compact('dealRequest', 'companies', 'deals', 'statuses', 'sources'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dealRequest = $this->DealRequests->get($id);
        if ($this->DealRequests->delete($dealRequest)) {
            $this->Flash->success(__('The deal request has been deleted.'));
        } else {
            $this->Flash->error(__('The deal request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
