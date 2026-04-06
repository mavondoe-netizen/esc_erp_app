<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Receipt> $receipts
 */
?>
<div class="receipts index content">
    <?= $this->Html->link(__('New Receipt'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Receipts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receipts as $receipt): ?>
                <tr>
                    <td><?= $this->Number->format($receipt->id) ?></td>
                    <td><?= $this->Number->format($receipt->supplier_id) ?></td>
                    <td><?= h($receipt->currency) ?></td>
                    <td><?= $this->Number->format($receipt->amount) ?></td>
                    <td><?= $receipt->hasValue('account') ? $this->Html->link($receipt->account->name, ['controller' => 'Accounts', 'action' => 'view', $receipt->account->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $receipt->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $receipt->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $receipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id)]) ?>
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