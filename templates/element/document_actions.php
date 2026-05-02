<?php
/**
 * Common actions for documents (Invoices, Bills, etc.)
 * @var \App\View\AppView $this
 * @var mixed $entity
 * @var string $controller
 * @var bool $approval_workflow
 */
$status = $entity->status ?? 'Draft';
?>

<div style="display: flex; gap: 8px;">
    <?php if ($controller === 'Estimates' && ($status === 'Draft' || $status === 'Sent')): ?>
        <?= $this->Form->postLink('<i class="fa fa-file-invoice"></i> Convert to Invoice', 
            ['controller' => 'Estimates', 'action' => 'convertToInvoice', $entity->id], 
            ['escape' => false, 'class' => 'btn-doc btn-info']) ?>
    <?php endif; ?>

    <?php if ($status === 'Draft' && $approval_workflow): ?>
        <?= $this->Form->postLink('<i class="fa fa-paper-plane"></i> Request Approval', 
            ['controller' => $controller, 'action' => 'requestForApproval', $entity->id], 
            ['escape' => false, 'class' => 'btn-doc btn-info']) ?>
    <?php endif; ?>

    <?php if ($status === 'Pending Approval'): ?>
        <?= $this->Form->postLink('<i class="fa fa-check"></i> Approve', 
            ['controller' => $controller, 'action' => 'approve', $entity->id], 
            ['escape' => false, 'class' => 'btn-doc btn-success', 'confirm' => 'Are you sure you want to approve this?']) ?>
        
        <?= $this->Form->postLink('<i class="fa fa-times"></i> Reject', 
            ['controller' => $controller, 'action' => 'reject', $entity->id], 
            ['escape' => false, 'class' => 'btn-doc btn-danger', 'confirm' => 'Are you sure you want to reject this?']) ?>
    <?php endif; ?>

    <?php if ($status !== 'Approved' && $status !== 'Sent' && $status !== 'Paid'): ?>
        <?= $this->Html->link('<i class="fa fa-edit"></i> Edit', 
            ['controller' => $controller, 'action' => 'edit', $entity->id], 
            ['escape' => false, 'class' => 'btn-doc btn-warning']) ?>
    <?php endif; ?>

    <?= $this->Form->postLink('<i class="fa fa-trash"></i> Delete', 
        ['controller' => $controller, 'action' => 'delete', $entity->id], 
        ['escape' => false, 'class' => 'btn-doc btn-danger', 'confirm' => 'Are you sure?']) ?>
</div>
