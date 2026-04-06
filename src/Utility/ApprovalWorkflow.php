<?php
namespace App\Utility;

use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;
use Cake\Datasource\ConnectionManager;

class ApprovalWorkflow
{
    /**
     * Initialize workflow for an entity
     */
    public static function initializeWorkflow($entityType, $entityId)
    {
        $approvalsTable = TableRegistry::getTableLocator()->get('Approvals');
        
        // Clear any old history for a fresh start
        $approvalsTable->deleteAll([
            'table_name' => $entityType,
            'entity_id' => $entityId
        ]);

        $table = TableRegistry::getTableLocator()->get($entityType);
        $entity = $table->get($entityId);
        
        // Find first stage
        $flowsTable = TableRegistry::getTableLocator()->get('ApprovalFlows');
        $firstStage = $flowsTable->find()
            ->where(['module_name' => $entityType])
            ->order(['level' => 'ASC'])
            ->first();

        if ($firstStage) {
            $entity->set('status', 'Pending Approval (Stage 1)');
        } else {
            $entity->set('status', 'Approved'); // Auto-approve if no flows configured
        }
        $table->save($entity);

        // Acknowledge receipt
        $entityName = $entity->get('name') ?: 'Record';
        self::sendContactNotification($entityType, $entityId, "Deal Received: {$entityName}", "We have received your deal ($entityName) and it is currently being processed by our team.");
    }

    /**
     * Process approval based on current stage in ApprovalFlows
     */
    public static function approve($entityType, $entityId, $userRoleId)
    {
        $approvalsTable = TableRegistry::getTableLocator()->get('Approvals');
        $flowsTable = TableRegistry::getTableLocator()->get('ApprovalFlows');

        // Get all defined stages for this module
        $stages = $flowsTable->find()
            ->where(['module_name' => $entityType])
            ->order(['level' => 'ASC'])
            ->all()
            ->toArray();

        // Get count of existing approved stages for this entity
        $approvedCount = $approvalsTable->find()
            ->where([
                'table_name' => $entityType,
                'entity_id' => $entityId,
                'status' => 'Approved'
            ])
            ->count();

        // If already fully approved or no stages exist
        if ($approvedCount >= count($stages)) {
            return false; 
        }

        $currentStage = $stages[$approvedCount];

        // Ensure user belongs to the role required for the CURRENT stage
        if ((int)$currentStage->role_id !== (int)$userRoleId) {
            return false;
        }

        // Record the approval
        $approval = $approvalsTable->newEntity([
            'table_name' => $entityType,
            'entity_id' => $entityId,
            'initiated_by' => $userRoleId, // Store role that approved it
            'approved_by' => null, // We just store role for simplicity if we don't have user ID passed
            'status' => 'Approved',
            'remarks' => 'Approved stage ' . ($approvedCount + 1),
            'approved_at' => date('Y-m-d H:i:s')
        ]);
        $approvalsTable->save($approval);

        // Check if this was the last stage
        if (($approvedCount + 1) >= count($stages)) {
            self::markAsFullyApproved($entityType, $entityId);
        } else {
            // Move to next stage status
            $table = TableRegistry::getTableLocator()->get($entityType);
            $entity = $table->get($entityId);
            $entity->set('status', 'Pending Approval (Stage ' . ($approvedCount + 2) . ')');
            $table->save($entity);
        }

        return true;
    }

    /**
     * Reject an entity.
     */
    public static function reject($entityType, $entityId, $userRoleId)
    {
        $table = TableRegistry::getTableLocator()->get($entityType);
        $entity = $table->get($entityId);
        
        if (strpos((string)$entity->get('status'), 'Pending Approval') === false) {
             return false; // Can only reject pending items
        }

        $entity->set('status', 'Rejected');
        $entity->set('rejection_reason', 'Rejected by role ' . $userRoleId);
        $table->save($entity);

        $approvalsTable = TableRegistry::getTableLocator()->get('Approvals');
        $approval = $approvalsTable->newEntity([
            'table_name' => $entityType,
            'entity_id' => $entityId,
            'initiated_by' => $userRoleId,
            'status' => 'Rejected',
            'remarks' => 'Deal rejected',
            'approved_at' => date('Y-m-d H:i:s')
        ]);
        $approvalsTable->save($approval);

        self::notifyRequestor($entityType, $entityId, 'rejected');

        // Notify contact
        $entityName = $entity->has('name') ? $entity->name : 'Record';
        self::sendContactNotification($entityType, $entityId, "Deal Update: Rejected", "Unfortunately, your deal ($entityName) has been rejected after review. Reason: {$entity->rejection_reason}");

        return true;
    }

    /**
     * When all stages are approved.
     */
    protected static function markAsFullyApproved($entityType, $entityId)
    {
        $table = TableRegistry::getTableLocator()->get($entityType);
        $entity = $table->get($entityId);
        $entity->set('status', 'Approved');
        $table->save($entity);

        self::notifyRequestor($entityType, $entityId, 'approved');

        // Notify contact
        $entityName = $entity->has('name') ? $entity->get('name') : 'Record';
        self::sendContactNotification($entityType, $entityId, "Deal Update: Approved", "Good news! Your deal ($entityName) has been fully approved by our team.");
    }

    /**
     * Notify requester or approver via email.
     */
    protected static function sendEmailNotification($userId, $subject, $message)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get($userId);

        $mailer = new Mailer('default');
        $mailer->setTo($user->get('email'))
            ->setSubject($subject)
            ->deliver($message);
    }

    protected static function notifyRequestor($entityType, $entityId, $status)
    {
        // Logic to find the requestor and notify
    }

    /**
     * Send email strictly to the Contact tied to this entity (e.g. Deals).
     */
    protected static function sendContactNotification($entityType, $entityId, $subject, $message)
    {
        try {
            if ($entityType !== 'Deals') return; 

            $table = TableRegistry::getTableLocator()->get($entityType);
            if (!$table->hasAssociation('Contacts')) return;

            $entity = $table->get($entityId, contain: ['Contacts']);
            $contact = $entity->get('contact');
            if ($contact && $contact->get('email')) {
                $mailer = new Mailer('default');
                $mailer->setTo($contact->get('email'))
                    ->setSubject($subject)
                    ->deliver($message);
            }
        } catch (\Exception $e) {
            // Silently fail if email config is missing/broken
        }
    }

    /**
     * Fetch approver based on role.
     */
    protected static function getUserByRole($roleId)
    {
        $usersRoles = TableRegistry::getTableLocator()->get('users');
        $userRole = $usersRoles->find()->where(['role_id' => $roleId])->first();
        return $userRole ? $userRole->user_id : null;
    }
}
