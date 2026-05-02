<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payments form content">
            <?= $this->Form->create($payment) ?>
            <fieldset>
                <legend><?= __('Add Payment') ?></legend>
                <?php
                    echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => '-- Select Supplier --']);
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Select Bank/Asset Account --', 'label' => 'Payment Into Account']);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('currency', ['options' => ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR']]);
                    echo $this->Form->control('payment_mode', [
                        'options' => [
                            'Bank Transfer' => 'Bank Transfer',
                            'Cash' => 'Cash',
                            'Mobile Money' => 'Mobile Money',
                            'Ecocash' => 'Ecocash'
                        ],
                        'empty' => '-- Select Mode --'
                    ]);
                    echo $this->Form->control('reference', ['label' => 'Payment Reference (e.g., Check #, Transfer ID)']);
                    echo $this->Form->control('date');
                    echo $this->Form->control('description', ['rows' => 3]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
