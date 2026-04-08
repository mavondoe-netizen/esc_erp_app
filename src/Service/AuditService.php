<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

class AuditService
{
    /**
     * Complete an audit action and check if finding is fully resolved.
     * 
     * @param int $actionId
     * @return bool
     */
    public function markActionCompleted(int $actionId): bool
    {
        $actionsTable = TableRegistry::getTableLocator()->get('AuditActions');
        $findingsTable = TableRegistry::getTableLocator()->get('AuditFindings');

        $action = $actionsTable->get($actionId);
        $action->status = 'Completed';
        $action->completion_date = date('Y-m-d H:i:s');
        if (!$actionsTable->save($action)) {
            return false;
        }

        // Check if finding is fully resolved
        $finding = $findingsTable->get($action->finding_id);
        $pendingActions = $actionsTable->find()
            ->where(['finding_id' => $finding->id, 'status !=' => 'Completed'])
            ->count();

        if ($pendingActions === 0) {
            $finding->status = 'Resolved';
            $findingsTable->save($finding);
        }

        return true;
    }
}
