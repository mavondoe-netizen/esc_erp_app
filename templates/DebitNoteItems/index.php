<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DebitNoteItem> $debitNoteItems
 */
?>
<div class="debitNoteItems index content">
    <?= $this->Html->link(__('New Debit Note Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Debit Note Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('debit_note_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('line_total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($debitNoteItems as $debitNoteItem): ?>
                <tr>
                    <td><?= $this->Number->format($debitNoteItem->id) ?></td>
                    <td><?= $debitNoteItem->hasValue('debit_note') ? $this->Html->link($debitNoteItem->debit_note->id, ['controller' => 'DebitNotes', 'action' => 'view', $debitNoteItem->debit_note->id]) : '' ?></td>
                    <td><?= $debitNoteItem->hasValue('product') ? $this->Html->link($debitNoteItem->product->name, ['controller' => 'Products', 'action' => 'view', $debitNoteItem->product->id]) : '' ?></td>
                    <td><?= $debitNoteItem->hasValue('account') ? $this->Html->link($debitNoteItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $debitNoteItem->account->id]) : '' ?></td>
                    <td><?= $debitNoteItem->quantity === null ? '' : $this->Number->format($debitNoteItem->quantity) ?></td>
                    <td><?= $debitNoteItem->unit_price === null ? '' : $this->Number->format($debitNoteItem->unit_price) ?></td>
                    <td><?= $debitNoteItem->line_total === null ? '' : $this->Number->format($debitNoteItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $debitNoteItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $debitNoteItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $debitNoteItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitNoteItem->id)]) ?>
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