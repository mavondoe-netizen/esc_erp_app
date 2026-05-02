<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ApprovalLevel> $approvalLevels
 */
?>
<div class="approvalLevels index content">
    <?= $this->Html->link(__('New Approval Level'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Approval Levels') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('entity') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('min_value') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approvalLevels as $approvalLevel): ?>
                <tr>
                    <td><?= $this->Number->format($approvalLevel->id) ?></td>
                    <td><?= h($approvalLevel->entity) ?></td>
                    <td><?= $this->Number->format($approvalLevel->level) ?></td>
                    <td><?= $approvalLevel->hasValue('role') ? $this->Html->link($approvalLevel->role->name, ['controller' => 'Roles', 'action' => 'view', $approvalLevel->role->id]) : '' ?></td>
                    <td><?= $approvalLevel->min_value === null ? '' : $this->Number->format($approvalLevel->min_value) ?></td>
                    <td><?= $approvalLevel->hasValue('company') ? $this->Html->link($approvalLevel->company->name, ['controller' => 'Companies', 'action' => 'view', $approvalLevel->company->id]) : '' ?></td>
                    <td><?= h($approvalLevel->created) ?></td>
                    <td><?= h($approvalLevel->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $approvalLevel->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $approvalLevel->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $approvalLevel->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $approvalLevel->id),
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