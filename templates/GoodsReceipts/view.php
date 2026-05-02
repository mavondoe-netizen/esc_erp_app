<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GoodsReceipt $goodsReceipt
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Goods Receipt'), ['action' => 'edit', $goodsReceipt->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Goods Receipt'), ['action' => 'delete', $goodsReceipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $goodsReceipt->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Goods Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Goods Receipt'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="goodsReceipts view content">
            <h3><?= h($goodsReceipt->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Contract') ?></th>
                    <td><?= $goodsReceipt->hasValue('contract') ? $this->Html->link($goodsReceipt->contract->contract_number, ['controller' => 'Contracts', 'action' => 'view', $goodsReceipt->contract->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $goodsReceipt->hasValue('user') ? $this->Html->link($goodsReceipt->user->role_id, ['controller' => 'Users', 'action' => 'view', $goodsReceipt->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($goodsReceipt->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $goodsReceipt->hasValue('company') ? $this->Html->link($goodsReceipt->company->name, ['controller' => 'Companies', 'action' => 'view', $goodsReceipt->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($goodsReceipt->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received Date') ?></th>
                    <td><?= h($goodsReceipt->received_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($goodsReceipt->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($goodsReceipt->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Goods Receipt Items') ?></h4>
                <?php if (!empty($goodsReceipt->goods_receipt_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Quantity Received') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($goodsReceipt->goods_receipt_items as $goodsReceiptItem) : ?>
                        <tr>
                            <td><?= h($goodsReceiptItem->id) ?></td>
                            <td><?= h($goodsReceiptItem->description) ?></td>
                            <td><?= h($goodsReceiptItem->quantity_received) ?></td>
                            <td><?= h($goodsReceiptItem->company_id) ?></td>
                            <td><?= h($goodsReceiptItem->created) ?></td>
                            <td><?= h($goodsReceiptItem->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GoodsReceiptItems', 'action' => 'view', $goodsReceiptItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GoodsReceiptItems', 'action' => 'edit', $goodsReceiptItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'GoodsReceiptItems', 'action' => 'delete', $goodsReceiptItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $goodsReceiptItem->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>