<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contract $contract
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Contract'), ['action' => 'edit', $contract->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Contract'), ['action' => 'delete', $contract->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contract->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contracts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Contract'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contracts view content">
            <h3><?= h($contract->contract_number) ?></h3>
            <table>
                <tr>
                    <th><?= __('Award') ?></th>
                    <td><?= $contract->hasValue('award') ? $this->Html->link($contract->award->id, ['controller' => 'Awards', 'action' => 'view', $contract->award->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Contract Number') ?></th>
                    <td><?= h($contract->contract_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($contract->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $contract->hasValue('company') ? $this->Html->link($contract->company->name, ['controller' => 'Companies', 'action' => 'view', $contract->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contract->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($contract->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($contract->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($contract->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($contract->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Sla Terms') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contract->sla_terms)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Goods Receipts') ?></h4>
                <?php if (!empty($contract->goods_receipts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Received By') ?></th>
                            <th><?= __('Received Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contract->goods_receipts as $goodsReceipt) : ?>
                        <tr>
                            <td><?= h($goodsReceipt->id) ?></td>
                            <td><?= h($goodsReceipt->received_by) ?></td>
                            <td><?= h($goodsReceipt->received_date) ?></td>
                            <td><?= h($goodsReceipt->status) ?></td>
                            <td><?= h($goodsReceipt->company_id) ?></td>
                            <td><?= h($goodsReceipt->created) ?></td>
                            <td><?= h($goodsReceipt->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GoodsReceipts', 'action' => 'view', $goodsReceipt->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GoodsReceipts', 'action' => 'edit', $goodsReceipt->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'GoodsReceipts', 'action' => 'delete', $goodsReceipt->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $goodsReceipt->id),
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