<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InvoiceItem> $invoiceItems
 */
?>
<div class="invoiceItems index content">
    <?= $this->Html->link(__('New Invoice Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoice Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('line_total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoiceItems as $invoiceItem): ?>
                <tr>
                    <td><?= $this->Number->format($invoiceItem->id) ?></td>
                    <td><?= $invoiceItem->hasValue('invoice') ? $this->Html->link($invoiceItem->invoice->currency, ['controller' => 'Invoices', 'action' => 'view', $invoiceItem->invoice->id]) : '' ?></td>
                    <td><?= $invoiceItem->hasValue('account') ? $this->Html->link($invoiceItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $invoiceItem->account->id]) : '' ?></td>
                    <td><?= $this->Number->format($invoiceItem->quantity) ?></td>
                    <td><?= $this->Number->format($invoiceItem->unit_price) ?></td>
                    <td><?= $this->Number->format($invoiceItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoiceItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->id)]) ?>
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