<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ComplianceCheck> $complianceChecks
 */
?>
<div class="complianceChecks index content">
    <?= $this->Html->link(__('New Compliance Check'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Compliance Checks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('obligation_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('checked_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complianceChecks as $complianceCheck): ?>
                <tr>
                    <td><?= $this->Number->format($complianceCheck->id) ?></td>
                    <td><?= $complianceCheck->hasValue('company') ? $this->Html->link($complianceCheck->company->name, ['controller' => 'Companies', 'action' => 'view', $complianceCheck->company->id]) : '' ?></td>
                    <td><?= $this->Number->format($complianceCheck->obligation_id) ?></td>
                    <td><?= h($complianceCheck->status) ?></td>
                    <td><?= h($complianceCheck->checked_at) ?></td>
                    <td><?= h($complianceCheck->created) ?></td>
                    <td><?= h($complianceCheck->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $complianceCheck->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $complianceCheck->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $complianceCheck->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complianceCheck->id)]) ?>
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