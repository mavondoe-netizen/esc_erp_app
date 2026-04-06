<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CreditNote> $creditNotes
 */
?>
<div class="creditNotes index content">
    <?= $this->Html->link(__('New Credit Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Credit Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
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
                <?php foreach ($creditNotes as $creditNote): ?>
                <tr>
                    <td><?= $this->Number->format($creditNote->id) ?></td>
                    <td><?= $creditNote->hasValue('company') ? $this->Html->link($creditNote->company->name, ['controller' => 'Companies', 'action' => 'view', $creditNote->company->id]) : '' ?></td>
                    <td><?= $creditNote->hasValue('customer') ? $this->Html->link($creditNote->customer->name, ['controller' => 'Customers', 'action' => 'view', $creditNote->customer->id]) : '' ?></td>
                    <td><?= h($creditNote->date) ?></td>
                    <td><?= h($creditNote->description) ?></td>
                    <td><?= $creditNote->total === null ? '' : $this->Number->format($creditNote->total) ?></td>
                    <td><?= h($creditNote->status) ?></td>
                    <td><?= h($creditNote->created) ?></td>
                    <td><?= h($creditNote->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $creditNote->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $creditNote->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $creditNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNote->id)]) ?>
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