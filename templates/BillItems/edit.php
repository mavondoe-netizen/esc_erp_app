<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillItem $billItem
 * @var string[]|\Cake\Collection\CollectionInterface $bills
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $billItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $billItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bill Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="billItems form content">
            <?= $this->Form->create($billItem) ?>
            <fieldset>
                <legend><?= __('Edit Bill Item') ?></legend>
                <?php
                    echo $this->Form->control('bill_id', ['options' => $bills]);
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('line_total');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
