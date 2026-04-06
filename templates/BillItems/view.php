<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillItem $billItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bill Item'), ['action' => 'edit', $billItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bill Item'), ['action' => 'delete', $billItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $billItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bill Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bill Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="billItems view content">
            <h3><?= h($billItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Bill') ?></th>
                    <td><?= $billItem->hasValue('bill') ? $this->Html->link($billItem->bill->description, ['controller' => 'Bills', 'action' => 'view', $billItem->bill->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $billItem->hasValue('account') ? $this->Html->link($billItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $billItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($billItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($billItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($billItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $this->Number->format($billItem->line_total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>