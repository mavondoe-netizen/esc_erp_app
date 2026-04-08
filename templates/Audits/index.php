<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Audit> $audits
 */
?>
<div class="audits index content">
    <?= $this->Html->link(__('New Audit'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('audit_plan_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('auditor_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($audits as $audit): ?>
                <tr>
                    <td><?= $this->Number->format($audit->id) ?></td>
                    <td><?= $audit->hasValue('company') ? $this->Html->link($audit->company->name, ['controller' => 'Companies', 'action' => 'view', $audit->company->id]) : '' ?></td>
                    <td><?= $audit->hasValue('audit_plan') ? $this->Html->link($audit->audit_plan->audit_type, ['controller' => 'AuditPlans', 'action' => 'view', $audit->audit_plan->id]) : '' ?></td>
                    <td><?= h($audit->title) ?></td>
                    <td><?= $audit->auditor_id === null ? '' : $this->Number->format($audit->auditor_id) ?></td>
                    <td><?= h($audit->status) ?></td>
                    <td><?= h($audit->created) ?></td>
                    <td><?= h($audit->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $audit->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $audit->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $audit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->id)]) ?>
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