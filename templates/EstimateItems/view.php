<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EstimateItem $estimateItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Estimate Item'), ['action' => 'edit', $estimateItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Estimate Item'), ['action' => 'delete', $estimateItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estimateItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Estimate Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Estimate Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estimateItems view content">
            <h3><?= h($estimateItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Estimate') ?></th>
                    <td><?= $estimateItem->hasValue('estimate') ? $this->Html->link($estimateItem->estimate->id, ['controller' => 'Estimates', 'action' => 'view', $estimateItem->estimate->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $estimateItem->hasValue('product') ? $this->Html->link($estimateItem->product->name, ['controller' => 'Products', 'action' => 'view', $estimateItem->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $estimateItem->hasValue('account') ? $this->Html->link($estimateItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $estimateItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($estimateItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $estimateItem->quantity === null ? '' : $this->Number->format($estimateItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $estimateItem->unit_price === null ? '' : $this->Number->format($estimateItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $estimateItem->line_total === null ? '' : $this->Number->format($estimateItem->line_total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>