<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ComplianceObligation> $complianceObligations
 */
?>
<div class="complianceObligations index content">
    <?= $this->Html->link(__('New Compliance Obligation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Compliance Obligations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('regulation_id') ?></th>
                    <th><?= $this->Paginator->sort('frequency') ?></th>
                    <th><?= $this->Paginator->sort('owner_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complianceObligations as $complianceObligation): ?>
                <tr>
                    <td><?= $this->Number->format($complianceObligation->id) ?></td>
                    <td><?= $complianceObligation->hasValue('company') ? $this->Html->link($complianceObligation->company->name, ['controller' => 'Companies', 'action' => 'view', $complianceObligation->company->id]) : '' ?></td>
                    <td><?= $complianceObligation->hasValue('regulation') ? $this->Html->link($complianceObligation->regulation->name, ['controller' => 'Regulations', 'action' => 'view', $complianceObligation->regulation->id]) : '' ?></td>
                    <td><?= h($complianceObligation->frequency) ?></td>
                    <td><?= $complianceObligation->owner_id === null ? '' : $this->Number->format($complianceObligation->owner_id) ?></td>
                    <td><?= h($complianceObligation->created) ?></td>
                    <td><?= h($complianceObligation->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $complianceObligation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $complianceObligation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $complianceObligation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complianceObligation->id)]) ?>
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