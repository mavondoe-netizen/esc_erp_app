<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Procurement> $procurements
 */
?>
<div class="procurements index content">
    <?= $this->Html->link(__('New Procurement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Procurements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('requisition_id') ?></th>
                    <th><?= $this->Paginator->sort('procurement_method') ?></th>
                    <th><?= $this->Paginator->sort('assigned_to') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($procurements as $procurement): ?>
                <tr>
                    <td><?= $this->Number->format($procurement->id) ?></td>
                    <td><?= $procurement->hasValue('requisition') ? $this->Html->link($procurement->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $procurement->requisition->id]) : '' ?></td>
                    <td><?= h($procurement->procurement_method) ?></td>
                    <td><?= $procurement->hasValue('user') ? $this->Html->link($procurement->user->role_id, ['controller' => 'Users', 'action' => 'view', $procurement->user->id]) : '' ?></td>
                    <td><?= h($procurement->status) ?></td>
                    <td><?= $procurement->hasValue('company') ? $this->Html->link($procurement->company->name, ['controller' => 'Companies', 'action' => 'view', $procurement->company->id]) : '' ?></td>
                    <td><?= h($procurement->created) ?></td>
                    <td><?= h($procurement->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $procurement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $procurement->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $procurement->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $procurement->id),
                            ]
                        ) ?>
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