<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Mailer\MailerAwareTrait;

/**
 * Deals Controller
 *
 * @property \App\Model\Table\DealsTable $Deals
 */
class DealsController extends AppController
{
    use MailerAwareTrait;

    /**
     * Index method
     */
    public function index()
    {
        $query = $this->Deals->find()
            ->contain(['Contacts']);
        $deals = $this->paginate($query);
        $this->set(compact('deals'));
    }

    /**
     * View method — loads the deal with its active approval record and history.
     */
    public function view($id = null)
    {
        $deal = $this->Deals->get($id, contain: ['Contacts']);

        // Load the most recent approval record for this deal
        $approvalsTable = $this->fetchTable('Approvals');
        $approval = $approvalsTable->find()
            ->where(['table_name' => 'Deals', 'entity_id' => $id])
            ->order(['Approvals.created' => 'DESC'])
            ->first();

        // Load approval history
        $approvalHistory = [];
        if ($approval) {
            $historiesTable = $this->fetchTable('ApprovalHistories');
            $approvalHistory = $historiesTable->find()
                ->where(['approval_id' => $approval->id])
                ->order(['ApprovalHistories.created' => 'ASC'])
                ->all()
                ->toArray();
        }

        // Load approval levels configured for Deals for this company
        $companyId = $this->request->getAttribute('company_id');
        $approvalLevelsTable = $this->fetchTable('ApprovalLevels');
        $approvalLevels = $approvalLevelsTable->find()
            ->contain(['Roles'])
            ->where(['ApprovalLevels.entity' => 'Deals', 'ApprovalLevels.company_id' => $companyId])
            ->order(['ApprovalLevels.level' => 'ASC'])
            ->all()
            ->toArray();

        // Determine if current user can act on the pending approval
        $currentUser = $this->request->getAttribute('identity');
        $currentUserRoleId = $currentUser ? (int)$currentUser->get('role_id') : 0;
        $canAct = false;

        if ($approval && strtolower((string)$approval->status) === 'pending') {
            // Check the flow for the current level
            $flowsTable = $this->fetchTable('ApprovalFlows');
            $currentFlow = $flowsTable->find()
                ->where(['module_name' => 'Deals', 'level' => $approval->current_level])
                ->first();
            if ($currentFlow && (int)$currentFlow->role_id === $currentUserRoleId) {
                $canAct = true;
            }
            // Super admin can always act
            if ($currentUserRoleId === 3) {
                $canAct = true;
            }
        }

        $this->set(compact('deal', 'approval', 'approvalHistory', 'approvalLevels', 'canAct'));
    }

    /**
     * Pipeline (Kanban Board)
     */
    public function pipeline()
    {
        $deals = $this->Deals->find('all')
            ->contain(['Contacts', 'Companies'])
            ->all()
            ->groupBy('stage')
            ->toArray();

        $stages = ['Lead', 'Qualified', 'Proposal', 'Negotiation', 'Closed Won', 'Closed Lost'];
        foreach ($stages as $stage) {
            if (!isset($deals[$stage])) {
                $deals[$stage] = [];
            }
        }
        $this->set(compact('deals'));
    }

    /**
     * Analytics
     */
    public function analytics()
    {
        $deals = $this->Deals->find('all')->all();
        $totalValue    = $deals->sumOf('value');
        $weightedValue = $deals->sumOf(function ($deal) {
            return ($deal->value * ($deal->probability ?? 0)) / 100;
        });
        $byStage = $this->Deals->find()
            ->select(['stage', 'count' => $this->Deals->find()->func()->count('*'), 'total' => $this->Deals->find()->func()->sum('value')])
            ->group(['stage'])->all()->toArray();
        $byType = $this->Deals->find()
            ->select(['type', 'count' => $this->Deals->find()->func()->count('*')])
            ->group(['type'])->all()->toArray();
        $this->set(compact('totalValue', 'weightedValue', 'byStage', 'byType'));
    }

    /**
     * Add method
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
        $contacts  = $this->Deals->Contacts->find('list', limit: 200)
            ->where(['Contacts.company_id' => $companyId])->all();
        $dealTypes = $this->_dealTypes();
        $this->set(compact('deal', 'contacts', 'dealTypes'));
    }

    /**
     * Edit method
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
        $contacts  = $this->Deals->Contacts->find('list', limit: 200)
            ->where(['Contacts.company_id' => $companyId])->all();
        $dealTypes = $this->_dealTypes();
        $this->set(compact('deal', 'contacts', 'dealTypes'));
    }

    /**
     * Delete method
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

    /**
     * Submit Deal for Approval — uses ApprovalService to create a multi-level approval record.
     */
    public function requestForApproval($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $deal = $this->Deals->get($id);

        if (!in_array($deal->status, ['Draft', 'Rejected', 'Active'])) {
            $this->Flash->error(__('This deal has already been submitted or is approved.'));
            return $this->redirect($this->referer(['action' => 'index']));
        }

        $deal->status       = 'Pending Approval';
        $deal->submitted_at = new \DateTime();
        $deal->submitted_by = $this->request->getAttribute('identity')->getIdentifier();

        if ($this->Deals->save($deal)) {
            $approvalService = new \App\Service\ApprovalService();
            $userId = (int)$this->Authentication->getIdentity()->get('id');
            if ($approvalService->start('Deals', (int)$deal->id, $userId)) {
                $this->Flash->success(__('The deal has been submitted for approval.'));
            } else {
                $this->Flash->warning(__('Deal submitted but approval workflow could not be started. Please check approval flow configuration.'));
            }
        } else {
            $this->Flash->error(__('The deal could not be submitted. Please try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Approve via ApprovalService (multi-level).
     */
    public function approveApproval($approvalId = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $remarks = (string)$this->request->getData('remarks', '');
        $userId  = (int)$this->Authentication->getIdentity()->get('id');

        $approvalService = new \App\Service\ApprovalService();
        if ($approvalService->progress((int)$approvalId, $userId, 'Approved', $remarks)) {
            $this->Flash->success(__('Approval progressed successfully.'));
        } else {
            $this->Flash->error(__('Could not process approval. Please try again.'));
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Reject via ApprovalService (multi-level).
     */
    public function rejectApproval($approvalId = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $remarks = (string)$this->request->getData('remarks', '');
        $userId  = (int)$this->Authentication->getIdentity()->get('id');

        $approvalService = new \App\Service\ApprovalService();
        if ($approvalService->progress((int)$approvalId, $userId, 'Rejected', $remarks)) {
            $this->Flash->success(__('Deal has been rejected.'));
        } else {
            $this->Flash->error(__('Could not process rejection. Please try again.'));
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Legacy direct approve (backward compat).
     */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $deal = $this->Deals->get($id);
        $deal->status      = 'Approved';
        $deal->approved_at = new \DateTime();
        $deal->approved_by = $this->request->getAttribute('identity')->getIdentifier();
        if ($this->Deals->save($deal)) {
            $this->_sendDealEmail($deal->id);
            $this->Flash->success(__('The deal has been approved.'));
        } else {
            $this->Flash->error(__('The deal could not be approved. Please, try again.'));
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Legacy direct reject (backward compat).
     */
    public function reject($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $deal = $this->Deals->get($id);
        $deal->status      = 'Rejected';
        $deal->rejected_at = new \DateTime();
        $deal->rejected_by = $this->request->getAttribute('identity')->getIdentifier();
        if ($this->Deals->save($deal)) {
            $this->_sendDealEmail($deal->id);
            $this->Flash->success(__('The deal has been rejected.'));
        } else {
            $this->Flash->error(__('The deal could not be rejected. Please, try again.'));
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Deal type options.
     */
    private function _dealTypes(): array
    {
        return [
            'Software Implementation'  => 'Software Implementation',
            'Tender'                   => 'Tender',
            'Payroll Service Contract' => 'Payroll Service Contract',
            'Loan Agreement'           => 'Loan Agreement',
            'ERP Subscription'         => 'ERP Subscription',
            'Property Lease'           => 'Property Lease',
        ];
    }

    /**
     * Send deal email.
     */
    private function _sendDealEmail(int $id): void
    {
        try {
            $deal  = $this->Deals->get($id, contain: ['Contacts']);
            $email = $deal->contact->email ?? null;
            if ($email) {
                $this->getMailer('Notification')->send('deal', [$deal->toArray(), $email]);
            }
        } catch (\Exception $e) {
            $this->Flash->warning(__('Deal saved, but email could not be sent: ' . $e->getMessage()));
        }
    }
}
