<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditPlan> $auditPlans
 */
?>
<div class="auditPlans index content">
    <?= $this->Html->link(__('New Audit Plan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Plans') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('year') ?></th>
                    <th><?= $this->Paginator->sort('business_unit_id') ?></th>
                    <th><?= $this->Paginator->sort('audit_type') ?></th>
                    <th><?= $this->Paginator->sort('planned_start') ?></th>
                    <th><?= $this->Paginator->sort('planned_end') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditPlans as $auditPlan): ?>
                <tr>
                    <td><?= $this->Number->format($auditPlan->id) ?></td>
                    <td><?= $auditPlan->hasValue('company') ? $this->Html->link($auditPlan->company->name, ['controller' => 'Companies', 'action' => 'view', $auditPlan->company->id]) : '' ?></td>
                    <td><?= $this->Number->format($auditPlan->year) ?></td>
                    <td><?= $auditPlan->business_unit_id === null ? '' : $this->Number->format($auditPlan->business_unit_id) ?></td>
                    <td><?= h($auditPlan->audit_type) ?></td>
                    <td><?= h($auditPlan->planned_start) ?></td>
                    <td><?= h($auditPlan->planned_end) ?></td>
                    <td><?= h($auditPlan->created) ?></td>
                    <td><?= h($auditPlan->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditPlan->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditPlan->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auditPlan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditPlan->id)]) ?>
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