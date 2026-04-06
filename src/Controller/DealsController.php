<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use App\Utility\AuditTrailUtility;
use App\Utility\ApprovalWorkflow;
use Cake\Error\Debugger;
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
public function submitForApproval($id)
{
    $deal = $this->fetchTable('Deals')->get($id);
    $userId = $this->request->getAttribute('identity')->role_id;

    ApprovalWorkflow::initializeWorkflow('Deals', $id);
    //Debugger::dump($id);
    
    $this->Flash->success('Deal submitted for approval.');

    return $this->redirect(['action' => 'view', $id]);
}


    public function index()
    {
        $query = $this->fetchTable('Deals')->find()
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
        $deal = $this->fetchTable('Deals')->get($id, contain: ['Contacts']);
        $this->set(compact('deal'));
    }

    /**
     * Set common view variables for forms
     */
    protected function setFormVariables()
    {
        $types = [
            'B2B' => 'B2B (Business to Business)',
            'B2C' => 'B2C (Business to Consumer)',
            'Partnership' => 'Partnership',
            'Government' => 'Government / Public Sector',
        ];
        $stages = [
            'Prospecting' => 'Prospecting',
            'Qualification' => 'Qualification',
            'Proposal' => 'Proposal / Presentation',
            'Negotiation' => 'Negotiation',
            'Closed Won' => 'Closed Won',
            'Closed Lost' => 'Closed Lost',
        ];
        $statuses = [
            'Draft' => 'Draft',
            'Pending Approval' => 'Pending Approval',
            'Approved' => 'Approved',
            'Rejected' => 'Rejected',
        ];

        // Fetch companies if associations exist, otherwise empty
        $companies = [];
        try {
            if ($this->fetchTable('Deals')->hasAssociation('Companies')) {
                $companies = $this->fetchTable('Deals')->Companies->find('list')->all();
            }
        } catch (\Exception $e) {}

        $this->set(compact('types', 'stages', 'statuses', 'companies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deal = $this->fetchTable('Deals')->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Default status for a new deal is Draft, but initializeWorkflow might change it.
            $data['status'] = 'Draft';
            
            $deal = $this->fetchTable('Deals')->patchEntity($deal, $data, [
                'accessibleFields' => [
                    'submitted_by' => false, 'submitted_at' => false,
                    'approved_by' => false, 'approved_at' => false,
                    'rejected_by' => false, 'rejected_at' => false, 'rejection_reason' => false
                ]
            ]);
            
            $deal->submitted_by = $this->request->getAttribute('identity')->role_id;
            $deal->submitted_at = date('Y-m-d H:i:s');  
            
            if ($this->fetchTable('Deals')->save($deal)) {
                
                
                

   ApprovalWorkflow::initializeWorkflow('Deals', $deal->id);
            $this->Flash->success(__('Deal saved and sent for approval.'));

                //$this->Flash->success(__('The deal has been saved.'));

                //AuditTrailUtility::log('Deals', $deal->id, 'Add', 'Deal created successfully');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Deals')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('deal', 'contacts'));
        $this->setFormVariables();
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
        $deal = $this->fetchTable('Deals')->get($id, contain: []);
        
        if ($deal->status === 'Approved') {
            $this->Flash->error(__('This deal has been fully approved and cannot be edited.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $deal = $this->fetchTable('Deals')->patchEntity($deal, $this->request->getData(), [
                'accessibleFields' => [
                    'submitted_by' => false, 'submitted_at' => false,
                    'approved_by' => false, 'approved_at' => false,
                    'rejected_by' => false, 'rejected_at' => false, 'rejection_reason' => false,
                    'status' => false // Prevent manual status override via form manipulation
                ]
            ]);
            
            if ($this->fetchTable('Deals')->save($deal)) {
                $this->Flash->success(__('Deal updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Deals')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('deal', 'contacts'));
        $this->setFormVariables();
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
        $deal = $this->fetchTable('Deals')->get($id);
        
        if ($deal->status === 'Approved') {
            $this->Flash->error(__('This deal has been fully approved and cannot be deleted.'));
            return $this->redirect($this->referer());
        }

        if (!$this->isAdmin()) {
            $this->Flash->error('Unauthorised action.');
            return $this->redirect($this->referer());
        }

        if ($this->fetchTable('Deals')->delete($deal)) {
            $this->Flash->success(__('The deal has been deleted.'));
        } else {
            $this->Flash->error(__('The deal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
        return $this->redirect(['action' => 'index']);
    }

    public function approve($id)
    {
        $userId = $this->request->getAttribute('identity')->get('id');
        $userRoleId = $this->request->getAttribute('identity')->get('role_id');

        // Pass the user ID and role ID to the workflow (we use role_id to check if they can approve)
        if (ApprovalWorkflow::approve('Deals', $id, $userRoleId)) {
            $this->Flash->success('Deal approved.');
        } else {
            $this->Flash->error('You are not authorized to approve this, or there are no pending stages.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function reject($id)
    {
        $userId = $this->request->getAttribute('identity')->get('id');
        $userRoleId = $this->request->getAttribute('identity')->get('role_id');

        if (ApprovalWorkflow::reject('Deals', $id, $userRoleId)) {
            $this->Flash->success('Deal rejected.');
        } else {
            $this->Flash->error('Action not permitted.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function requestForApproval($id)
    {
        ApprovalWorkflow::initializeWorkflow('Deals', $id);
        $this->Flash->success('Deal submitted for approval.');

        return $this->redirect(['action' => 'view', $id]);
    }
}
