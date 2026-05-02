<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>
<div class="invoices index content">
    <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoices') ?></h3>
    <div class="table-controls" style="margin-bottom: 1.5rem; background: #f8fafc; padding: 1rem; border-radius: 8px;">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row']) ?>
        <div class="column"><?= $this->Form->control('status', ['options' => ['' => 'All Statuses', 'Draft' => 'Draft', 'Sent' => 'Sent', 'Paid' => 'Paid'], 'value' => $this->request->getQuery('status')]) ?></div>
        <div class="column"><?= $this->Form->control('contact_id', ['options' => $customers, 'empty' => 'All Clients', 'label' => 'Client (Contact)', 'value' => $this->request->getQuery('contact_id')]) ?></div>
        <div class="column"><?= $this->Form->control('start_date', ['type' => 'date', 'value' => $this->request->getQuery('start_date')]) ?></div>
        <div class="column"><?= $this->Form->control('end_date', ['type' => 'date', 'value' => $this->request->getQuery('end_date')]) ?></div>
        <div class="column" style="display: flex; align-items: flex-end;">
            <?= $this->Form->button(__('Filter'), ['class' => 'button']) ?>
            <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'button secondary', 'style' => 'margin-left: 10px;']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('customer_id', 'Client') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('manual_reference', 'Manual Ref') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?= $this->Number->format($invoice->id) ?></td>
                    <td><?= h($invoice->date) ?></td>
                    <td><?= $invoice->hasValue('customer') ? $this->Html->link($invoice->customer->name, ['controller' => 'Customers', 'action' => 'view', $invoice->customer->id]) : '' ?></td>
                    <td><?= h($invoice->currency) ?></td>
                    <td><?= h($invoice->description) ?></td>
                    <td><?= h($invoice->status) ?></td>
                    <td><?= h($invoice->manual_reference) ?></td>
                    <td><?= $this->Number->currency($invoice->total, $invoice->currency) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoice->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?>
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