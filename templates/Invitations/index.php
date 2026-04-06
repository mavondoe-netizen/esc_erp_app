<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invitation> $invitations
 */
?>
<div class="invitations index content">
    <?= $this->Html->link(__('New Invitation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invitations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invitations as $invitation): ?>
                <tr>
                    <td><?= $this->Number->format($invitation->id) ?></td>
                    <td><?= h($invitation->email) ?></td>
                    <td><?= $invitation->hasValue('company') ? $this->Html->link($invitation->company->name, ['controller' => 'Companies', 'action' => 'view', $invitation->company->id]) : '' ?></td>
                    <td><?= $invitation->hasValue('role') ? $this->Html->link($invitation->role->name, ['controller' => 'Roles', 'action' => 'view', $invitation->role->id]) : '' ?></td>
                    <td><?= h($invitation->status) ?></td>
                    <td><?= h($invitation->created) ?></td>
                    <td><?= h($invitation->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invitation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invitation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invitation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>