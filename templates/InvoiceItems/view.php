<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItem $invoiceItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice Item'), ['action' => 'edit', $invoiceItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice Item'), ['action' => 'delete', $invoiceItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoice Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItems view content">
            <h3><?= h($invoiceItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Invoice') ?></th>
                    <td><?= $invoiceItem->hasValue('invoice') ? $this->Html->link($invoiceItem->invoice->currency, ['controller' => 'Invoices', 'action' => 'view', $invoiceItem->invoice->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $invoiceItem->hasValue('account') ? $this->Html->link($invoiceItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $invoiceItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invoiceItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($invoiceItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($invoiceItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $this->Number->format($invoiceItem->line_total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>