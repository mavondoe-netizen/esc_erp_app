<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DebitNote> $debitNotes
 */
?>
<div class="debitNotes index content">
    <?= $this->Html->link(__('New Debit Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Debit Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($debitNotes as $debitNote): ?>
                <tr>
                    <td><?= $this->Number->format($debitNote->id) ?></td>
                    <td><?= $debitNote->hasValue('company') ? $this->Html->link($debitNote->company->name, ['controller' => 'Companies', 'action' => 'view', $debitNote->company->id]) : '' ?></td>
                    <td><?= $debitNote->hasValue('supplier') ? $this->Html->link($debitNote->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $debitNote->supplier->id]) : '' ?></td>
                    <td><?= h($debitNote->date) ?></td>
                    <td><?= h($debitNote->description) ?></td>
                    <td><?= $debitNote->total === null ? '' : $this->Number->format($debitNote->total) ?></td>
                    <td><?= h($debitNote->status) ?></td>
                    <td><?= h($debitNote->created) ?></td>
                    <td><?= h($debitNote->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $debitNote->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $debitNote->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $debitNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitNote->id)]) ?>
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