<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\GoodsReceipt> $goodsReceipts
 */
?>
<div class="goodsReceipts index content">
    <?= $this->Html->link(__('New Goods Receipt'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Goods Receipts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('contract_id') ?></th>
                    <th><?= $this->Paginator->sort('received_by') ?></th>
                    <th><?= $this->Paginator->sort('received_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($goodsReceipts as $goodsReceipt): ?>
                <tr>
                    <td><?= $this->Number->format($goodsReceipt->id) ?></td>
                    <td><?= $goodsReceipt->hasValue('contract') ? $this->Html->link($goodsReceipt->contract->contract_number, ['controller' => 'Contracts', 'action' => 'view', $goodsReceipt->contract->id]) : '' ?></td>
                    <td><?= $goodsReceipt->hasValue('user') ? $this->Html->link($goodsReceipt->user->role_id, ['controller' => 'Users', 'action' => 'view', $goodsReceipt->user->id]) : '' ?></td>
                    <td><?= h($goodsReceipt->received_date) ?></td>
                    <td><?= h($goodsReceipt->status) ?></td>
                    <td><?= $goodsReceipt->hasValue('company') ? $this->Html->link($goodsReceipt->company->name, ['controller' => 'Companies', 'action' => 'view', $goodsReceipt->company->id]) : '' ?></td>
                    <td><?= h($goodsReceipt->created) ?></td>
                    <td><?= h($goodsReceipt->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $goodsReceipt->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $goodsReceipt->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $goodsReceipt->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $goodsReceipt->id),
                            ]
                        ) ?>
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