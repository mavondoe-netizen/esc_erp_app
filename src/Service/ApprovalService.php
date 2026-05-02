<?php
declare(strict_types=1);

namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Reusable Approval Service for managing multi-step workflows.
 */
class ApprovalService
{
    /**
     * Start an approval workflow for an entity.
     *
     * @param string $module The module name (e.g., 'Requisitions', 'Awards')
     * @param int $entityId The ID of the entity to approve
     * @param int $initiatedBy The ID of the user who initiated the request
     * @return bool Success or failure
     */
    public function start(string $module, int $entityId, int $initiatedBy): bool
    {
        $approvalFlows = TableRegistry::getTableLocator()->get('ApprovalFlows');
        $approvals = TableRegistry::getTableLocator()->get('Approvals');
        $histories = TableRegistry::getTableLocator()->get('ApprovalHistories');

        // Check if a flow exists for this module
        $firstFlow = $approvalFlows->find()
            ->where(['module_name' => $module])
            ->order(['level' => 'ASC'])
            ->first();

        if (!$firstFlow) {
            // No flow defined, auto-approve
            $this->updateEntityStatus($module, $entityId, 'Approved');
            return true;
        }

        $approval = $approvals->newEntity([
            'table_name' => $module,
            'entity_id' => $entityId,
            'status' => 'Pending',
            'initiated_by' => $initiatedBy,
            'current_level' => $firstFlow->level,
        ]);

        if ($approvals->save($approval)) {
            // Log history
            $history = $histories->newEntity([
                'approval_id' => $approval->id,
                'action' => 'Initiated',
                'level' => 0,
                'performed_by' => $initiatedBy,
                'remarks' => 'Approval process started.'
            ]);
            $histories->save($history);
            return true;
        }

        return false;
    }

    /**
     * Progress the approval to the next level or finalize it.
     *
     * @param int $approvalId The ID of the approval record
     * @param int $approverId The ID of the user performing the action
     * @param string $status 'Approved' or 'Rejected'
     * @param string $remarks Optional comments
     * @return bool
     */
    public function progress(int $approvalId, int $approverId, string $status, string $remarks = ''): bool
    {
        $approvals = TableRegistry::getTableLocator()->get('Approvals');
        $approvalFlows = TableRegistry::getTableLocator()->get('ApprovalFlows');
        $histories = TableRegistry::getTableLocator()->get('ApprovalHistories');

        $approval = $approvals->get($approvalId);
        
        if ($status === 'Rejected') {
            $approval->status = 'Rejected';
            $approvals->save($approval);
            
            $this->updateEntityStatus($approval->table_name, $approval->entity_id, 'Rejected');
            
            $history = $histories->newEntity([
                'approval_id' => $approval->id,
                'action' => 'Rejected',
                'level' => $approval->current_level,
                'performed_by' => $approverId,
                'remarks' => $remarks
            ]);
            $histories->save($history);
            
            return true;
        }

        // Find next level
        $nextFlow = $approvalFlows->find()
            ->where(['module_name' => $approval->table_name, 'level >' => $approval->current_level])
            ->order(['level' => 'ASC'])
            ->first();

        $oldLevel = $approval->current_level;

        if ($nextFlow) {
            $approval->current_level = $nextFlow->level;
            $approval->status = 'Pending Level ' . $nextFlow->level;
        } else {
            $approval->status = 'Approved';
            $approval->approved_by = $approverId;
            $approval->approved_at = date('Y-m-d H:i:s');
            
            $this->updateEntityStatus($approval->table_name, $approval->entity_id, 'Approved');
        }

        if ($approvals->save($approval)) {
             $history = $histories->newEntity([
                'approval_id' => $approval->id,
                'action' => 'Approved',
                'level' => $oldLevel,
                'performed_by' => $approverId,
                'remarks' => $remarks
            ]);
            $histories->save($history);
            return true;
        }

        return false;
    }

    /**
     * Update the status of the underlying entity and trigger follow-up actions.
     */
    private function updateEntityStatus(string $tableName, int $entityId, string $status): void
    {
        try {
            $table = TableRegistry::getTableLocator()->get($tableName);
            $entity = $table->get($entityId);
            $entity->set('status', $status);
            $table->save($entity);
            
            // Trigger side-effects for final approval
            if ($status === 'Approved') {
                if ($tableName === 'Awards') {
                    $this->generateBillFromAward($entity);
                }
                if ($tableName === 'Requisitions') {
                    $this->createProcurementFromRequisition($entity);
                }
            }
        } catch (\Exception $e) {
            Log::error("ApprovalService: Failed to update entity status for $tableName($entityId): " . $e->getMessage());
        }
    }
    
    /**
     * Create a Bill from an Approved Award.
     */
    private function generateBillFromAward($award): void
    {
        $Bills = TableRegistry::getTableLocator()->get('Bills');
        $Tenders = TableRegistry::getTableLocator()->get('Tenders');
        
        $tender = $Tenders->get($award->tender_id);
        
        $bill = $Bills->newEntity([
            'company_id' => $award->company_id,
            'supplier_id' => $award->supplier_id,
            'award_id' => $award->id,
            'date' => date('Y-m-d'),
            'description' => 'Generated from Award for Tender: ' . $tender->title,
            'status' => 'Draft',
            'currency' => 'USD', // Default or fetch from tender
            'total' => $award->awarded_amount,
        ]);
        
        $Bills->save($bill);
    }

    /**
     * Automatically create a Procurement case from an Approved Requisition.
     */
    private function createProcurementFromRequisition($requisition): void
    {
        $Procurements = TableRegistry::getTableLocator()->get('Procurements');
        
        $procurement = $Procurements->newEntity([
            'requisition_id' => $requisition->id,
            'procurement_method' => 'RFQ', // Default
            'status' => 'Open',
            'company_id' => $requisition->company_id,
        ]);
        
        $Procurements->save($procurement);
    }
}
