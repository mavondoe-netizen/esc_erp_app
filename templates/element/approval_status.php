
<?php if ($entity->status === 'pending'): ?>
    <div class="actions">
        <?= $this->Form->postLink(
            __('Approve'),
            ['action' => 'approve', $entity->id],
            ['class' => 'btn btn-success', 'confirm' => __('Are you sure you want to approve this deal?')]
        ) ?>

        <?= $this->Form->postLink(
            __('Reject'),
            ['action' => 'reject', $entity->id],
            ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to reject this deal?')]
        ) ?>
    </div>
<?php endif; ?>