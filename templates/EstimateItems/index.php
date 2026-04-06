<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\EstimateItem> $estimateItems
 */
?>
<div class="estimateItems index content">
    <?= $this->Html->link(__('New Estimate Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Estimate Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estimate_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('line_total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estimateItems as $estimateItem): ?>
                <tr>
                    <td><?= $this->Number->format($estimateItem->id) ?></td>
                    <td><?= $estimateItem->hasValue('estimate') ? $this->Html->link($estimateItem->estimate->id, ['controller' => 'Estimates', 'action' => 'view', $estimateItem->estimate->id]) : '' ?></td>
                    <td><?= $estimateItem->hasValue('product') ? $this->Html->link($estimateItem->product->name, ['controller' => 'Products', 'action' => 'view', $estimateItem->product->id]) : '' ?></td>
                    <td><?= $estimateItem->hasValue('account') ? $this->Html->link($estimateItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $estimateItem->account->id]) : '' ?></td>
                    <td><?= $estimateItem->quantity === null ? '' : $this->Number->format($estimateItem->quantity) ?></td>
                    <td><?= $estimateItem->unit_price === null ? '' : $this->Number->format($estimateItem->unit_price) ?></td>
                    <td><?= $estimateItem->line_total === null ? '' : $this->Number->format($estimateItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $estimateItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estimateItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estimateItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estimateItem->id)]) ?>
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