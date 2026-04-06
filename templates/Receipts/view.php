<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Receipt'), ['action' => 'edit', $receipt->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Receipt'), ['action' => 'delete', $receipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Receipt'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="receipts view content">
            <h3><?= h($receipt->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($receipt->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $receipt->hasValue('account') ? $this->Html->link($receipt->account->name, ['controller' => 'Accounts', 'action' => 'view', $receipt->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($receipt->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier Id') ?></th>
                    <td><?= $this->Number->format($receipt->supplier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($receipt->amount) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($receipt->transactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Zwg') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Building Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($receipt->transactions as $transaction) : ?>
                        <tr>
                            <td><?= h($transaction->id) ?></td>
                            <td><?= h($transaction->date) ?></td>
                            <td><?= h($transaction->description) ?></td>
                            <td><?= h($transaction->currency) ?></td>
                            <td><?= h($transaction->amount) ?></td>
                            <td><?= h($transaction->zwg) ?></td>
                            <td><?= h($transaction->account_id) ?></td>
                            <td><?= h($transaction->building_id) ?></td>
                            <td><?= h($transaction->tenant_id) ?></td>
                            <td><?= h($transaction->supplier_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transaction->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transactions', 'action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
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