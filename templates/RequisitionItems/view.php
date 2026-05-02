<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionItem $requisitionItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Requisition Item'), ['action' => 'edit', $requisitionItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Requisition Item'), ['action' => 'delete', $requisitionItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requisitionItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Requisition Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Requisition Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="requisitionItems view content">
            <h3><?= h($requisitionItem->item_description) ?></h3>
            <table>
                <tr>
                    <th><?= __('Requisition') ?></th>
                    <td><?= $requisitionItem->hasValue('requisition') ? $this->Html->link($requisitionItem->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $requisitionItem->requisition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Description') ?></th>
                    <td><?= h($requisitionItem->item_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $requisitionItem->hasValue('company') ? $this->Html->link($requisitionItem->company->name, ['controller' => 'Companies', 'action' => 'view', $requisitionItem->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($requisitionItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($requisitionItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estimated Unit Price') ?></th>
                    <td><?= $this->Number->format($requisitionItem->estimated_unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($requisitionItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($requisitionItem->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>