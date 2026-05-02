<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="receipts form content">
            <?= $this->Form->create($receipt) ?>
            <fieldset>
                <legend><?= __('Add Receipt') ?></legend>
                <?php
                    echo $this->Form->control('customer_id', ['options' => $customers, 'empty' => '-- Select Customer --']);
                    echo $this->Form->control('currency', ['options' => ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR']]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Select Bank/Asset Account --', 'label' => 'Deposited Into Account']);
                    echo $this->Form->control('reference', ['label' => 'Reference (e.g., Bank Ref, Invoice #)']);
                    echo $this->Form->control('date');
                    echo $this->Form->control('description', ['rows' => 2]);
                    echo $this->Form->control('status', ['options' => ['Draft' => 'Draft', 'Pending Approval' => 'Pending Approval', 'Approved' => 'Approved', 'Rejected' => 'Rejected']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button secondary', 'style' => 'margin-left: 10px;']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
