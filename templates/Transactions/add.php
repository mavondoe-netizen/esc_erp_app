<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var \Cake\Collection\CollectionInterface|string[] $buildings
 * @var \Cake\Collection\CollectionInterface|string[] $tenants
 * @var \Cake\Collection\CollectionInterface|string[] $bankTransactions
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $bills
 * @var \Cake\Collection\CollectionInterface|string[] $invoices
 * @var \Cake\Collection\CollectionInterface|string[] $receipts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="transactions form content">
            <?= $this->Form->create($transaction) ?>
            <fieldset>
                <legend><?= __('Add Transaction') ?></legend>
                <?php
                    echo $this->Form->control('bank_transaction_id', ['options' => $bankTransactions, 'empty' => true]);
                    echo $this->Form->control('date');
                    echo $this->Form->control('description');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('zwg');
                    echo $this->Form->control('type');
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('department_id');
                    echo $this->Form->control('building_id', ['options' => $buildings, 'empty' => true]);
                    echo $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]);
                    echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => true]);
                    echo $this->Form->control('customer_id', ['options' => $customers, 'empty' => true]);
                    echo $this->Form->control('company_id');
                    echo $this->Form->control('bills._ids', ['options' => $bills]);
                    echo $this->Form->control('invoices._ids', ['options' => $invoices]);
                    echo $this->Form->control('receipts._ids', ['options' => $receipts]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
