<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Requisition> $requisitions
 */
?>
<div class="requisitions index content">
    <?= $this->Html->link(__('New Requisition'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Requisitions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('department_id') ?></th>
                    <th><?= $this->Paginator->sort('requested_by') ?></th>
                    <th><?= $this->Paginator->sort('total_estimated_cost') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('manual_reference', 'Manual Ref') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisitions as $requisition): ?>
                <tr>
                    <td><?= $this->Number->format($requisition->id) ?></td>
                    <td><?= $requisition->hasValue('department') ? $this->Html->link($requisition->department->name, ['controller' => 'Departments', 'action' => 'view', $requisition->department->id]) : '' ?></td>
                    <td><?= $requisition->hasValue('user') ? $this->Html->link($requisition->user->role_id, ['controller' => 'Users', 'action' => 'view', $requisition->user->id]) : '' ?></td>
                    <td><?= $requisition->total_estimated_cost === null ? '' : $this->Number->format($requisition->total_estimated_cost) ?></td>
                    <td><?= h($requisition->status) ?></td>
                    <td><?= h($requisition->manual_reference) ?></td>
                    <td><?= $requisition->hasValue('company') ? $this->Html->link($requisition->company->name, ['controller' => 'Companies', 'action' => 'view', $requisition->company->id]) : '' ?></td>
                    <td><?= h($requisition->created) ?></td>
                    <td><?= h($requisition->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $requisition->id]) ?>
                        <?php if ($requisition->status === 'Draft' || $requisition->status === 'Rejected'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requisition->id]) ?>
                            <?= $this->Form->postLink(__('Submit'), ['action' => 'submit', $requisition->id], ['confirm' => __('Submit this requisition for approval?')]) ?>
                        <?php endif; ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $requisition->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $requisition->id),
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