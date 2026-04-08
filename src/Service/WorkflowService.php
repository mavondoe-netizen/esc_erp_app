<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

class WorkflowService
{
    /**
     * Submits an entity for approval using the generic approvals table.
     * 
     * @param string $tableName e.g. 'risks', 'audits', 'incidents'
     * @param int $entityId
     * @param int $initiatedBy (User ID)
     * @return bool
     */
    public function submitForApproval(string $tableName, int $entityId, int $initiatedBy): bool
    {
        $approvalsTable = TableRegistry::getTableLocator()->get('Approvals');
        $historiesTable = TableRegistry::getTableLocator()->get('ApprovalHistories');

        $approval = $approvalsTable->newEmptyEntity();
        $approval->table_name = $tableName;
        $approval->entity_id = $entityId;
        $approval->status = 'Pending';
        $approval->level = 1;
        $approval->initiated_by = $initiatedBy;
        $approval->created = date('Y-m-d H:i:s');

        if ($approvalsTable->save($approval)) {
            // Log history
            $history = $historiesTable->newEmptyEntity();
            $history->approval_id = $approval->id;
            $history->action = 'Submitted';
            $history->level = 1;
            $history->performed_by = $initiatedBy;
            $history->created = date('Y-m-d H:i:s');
            $historiesTable->save($history);

            return true;
        }

        return false;
    }
}
