<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BillItem> $billItems
 */
?>
<div class="billItems index content">
    <?= $this->Html->link(__('New Bill Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bill Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('bill_id') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('line_total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($billItems as $billItem): ?>
                <tr>
                    <td><?= $this->Number->format($billItem->id) ?></td>
                    <td><?= $billItem->hasValue('bill') ? $this->Html->link($billItem->bill->description, ['controller' => 'Bills', 'action' => 'view', $billItem->bill->id]) : '' ?></td>
                    <td><?= $billItem->hasValue('account') ? $this->Html->link($billItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $billItem->account->id]) : '' ?></td>
                    <td><?= $this->Number->format($billItem->quantity) ?></td>
                    <td><?= $this->Number->format($billItem->unit_price) ?></td>
                    <td><?= $this->Number->format($billItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $billItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $billItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $billItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $billItem->id)]) ?>
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