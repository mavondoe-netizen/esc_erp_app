<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CreditNoteItem $creditNoteItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Credit Note Item'), ['action' => 'edit', $creditNoteItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Credit Note Item'), ['action' => 'delete', $creditNoteItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNoteItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Credit Note Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Credit Note Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="creditNoteItems view content">
            <h3><?= h($creditNoteItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Credit Note') ?></th>
                    <td><?= $creditNoteItem->hasValue('credit_note') ? $this->Html->link($creditNoteItem->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $creditNoteItem->credit_note->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $creditNoteItem->hasValue('product') ? $this->Html->link($creditNoteItem->product->name, ['controller' => 'Products', 'action' => 'view', $creditNoteItem->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $creditNoteItem->hasValue('account') ? $this->Html->link($creditNoteItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $creditNoteItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($creditNoteItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $creditNoteItem->quantity === null ? '' : $this->Number->format($creditNoteItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $creditNoteItem->unit_price === null ? '' : $this->Number->format($creditNoteItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $creditNoteItem->line_total === null ? '' : $this->Number->format($creditNoteItem->line_total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>