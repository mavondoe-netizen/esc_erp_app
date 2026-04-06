<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inspection> $inspections
 */
?>
<div class="inspections index content">
    <?= $this->Html->link(__('New Inspection'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inspections') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('pobs_insurable') ?></th>
                    <th><?= $this->Paginator->sort('apwcs_insurable') ?></th>
                    <th><?= $this->Paginator->sort('apwcs_penalty') ?></th>
                    <th><?= $this->Paginator->sort('inspector_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inspections as $inspection): ?>
                <tr>
                    <td><?= $this->Number->format($inspection->id) ?></td>
                    <td><?= h($inspection->name) ?></td>
                    <td><?= $inspection->hasValue('customer') ? $this->Html->link($inspection->customer->name, ['controller' => 'Customers', 'action' => 'view', $inspection->customer->id]) : '' ?></td>
                    <td><?= h($inspection->date) ?></td>
                    <td><?= $this->Number->format($inspection->pobs_insurable) ?></td>
                    <td><?= $this->Number->format($inspection->apwcs_insurable) ?></td>
                    <td><?= $this->Number->format($inspection->apwcs_penalty) ?></td>
                    <td><?= $inspection->hasValue('inspector') ? $this->Html->link($inspection->inspector->name, ['controller' => 'Inspectors', 'action' => 'view', $inspection->inspector->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inspection->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inspection->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inspection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id)]) ?>
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