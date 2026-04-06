<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bill $bill
 * @var string[]|\Cake\Collection\CollectionInterface $suppliers
 * @var string[]|\Cake\Collection\CollectionInterface $transactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bill->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bills'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bills form content">
            <?= $this->Form->create($bill) ?>
            <fieldset>
                <legend><?= __('Edit Bill') ?></legend>
                <?php
                    echo $this->Form->control('company_id');
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('date');
                    echo $this->Form->control('description');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('total');
                    echo $this->Form->control('department_id');
                    echo $this->Form->control('transactions._ids', ['options' => $transactions]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
