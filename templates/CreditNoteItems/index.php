<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CreditNoteItem> $creditNoteItems
 */
?>
<div class="creditNoteItems index content">
    <?= $this->Html->link(__('New Credit Note Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Credit Note Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('credit_note_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('line_total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($creditNoteItems as $creditNoteItem): ?>
                <tr>
                    <td><?= $this->Number->format($creditNoteItem->id) ?></td>
                    <td><?= $creditNoteItem->hasValue('credit_note') ? $this->Html->link($creditNoteItem->credit_note->id, ['controller' => 'CreditNotes', 'action' => 'view', $creditNoteItem->credit_note->id]) : '' ?></td>
                    <td><?= $creditNoteItem->hasValue('product') ? $this->Html->link($creditNoteItem->product->name, ['controller' => 'Products', 'action' => 'view', $creditNoteItem->product->id]) : '' ?></td>
                    <td><?= $creditNoteItem->hasValue('account') ? $this->Html->link($creditNoteItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $creditNoteItem->account->id]) : '' ?></td>
                    <td><?= $creditNoteItem->quantity === null ? '' : $this->Number->format($creditNoteItem->quantity) ?></td>
                    <td><?= $creditNoteItem->unit_price === null ? '' : $this->Number->format($creditNoteItem->unit_price) ?></td>
                    <td><?= $creditNoteItem->line_total === null ? '' : $this->Number->format($creditNoteItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $creditNoteItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $creditNoteItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $creditNoteItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNoteItem->id)]) ?>
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