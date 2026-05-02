<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payments form content">
            <?= $this->Form->create($payment) ?>
            <fieldset>
                <legend><?= __('Edit Payment') ?></legend>
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
