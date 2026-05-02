<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RequisitionItem> $requisitionItems
 */
?>
<div class="requisitionItems index content">
    <?= $this->Html->link(__('New Requisition Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Requisition Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('requisition_id') ?></th>
                    <th><?= $this->Paginator->sort('item_description') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('estimated_unit_price') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisitionItems as $requisitionItem): ?>
                <tr>
                    <td><?= $this->Number->format($requisitionItem->id) ?></td>
                    <td><?= $requisitionItem->hasValue('requisition') ? $this->Html->link($requisitionItem->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $requisitionItem->requisition->id]) : '' ?></td>
                    <td><?= h($requisitionItem->item_description) ?></td>
                    <td><?= $this->Number->format($requisitionItem->quantity) ?></td>
                    <td><?= $this->Number->format($requisitionItem->estimated_unit_price) ?></td>
                    <td><?= $requisitionItem->hasValue('company') ? $this->Html->link($requisitionItem->company->name, ['controller' => 'Companies', 'action' => 'view', $requisitionItem->company->id]) : '' ?></td>
                    <td><?= h($requisitionItem->created) ?></td>
                    <td><?= h($requisitionItem->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $requisitionItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requisitionItem->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $requisitionItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $requisitionItem->id),
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