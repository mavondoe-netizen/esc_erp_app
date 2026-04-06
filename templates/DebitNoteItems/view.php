<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitNoteItem $debitNoteItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Debit Note Item'), ['action' => 'edit', $debitNoteItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Debit Note Item'), ['action' => 'delete', $debitNoteItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitNoteItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Debit Note Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Debit Note Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="debitNoteItems view content">
            <h3><?= h($debitNoteItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Debit Note') ?></th>
                    <td><?= $debitNoteItem->hasValue('debit_note') ? $this->Html->link($debitNoteItem->debit_note->id, ['controller' => 'DebitNotes', 'action' => 'view', $debitNoteItem->debit_note->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $debitNoteItem->hasValue('product') ? $this->Html->link($debitNoteItem->product->name, ['controller' => 'Products', 'action' => 'view', $debitNoteItem->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $debitNoteItem->hasValue('account') ? $this->Html->link($debitNoteItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $debitNoteItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($debitNoteItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $debitNoteItem->quantity === null ? '' : $this->Number->format($debitNoteItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $debitNoteItem->unit_price === null ? '' : $this->Number->format($debitNoteItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $debitNoteItem->line_total === null ? '' : $this->Number->format($debitNoteItem->line_total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>