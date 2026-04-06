<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $budget->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Budgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="budgets form content">
            <?= $this->Form->create($budget) ?>
            <fieldset>
                <legend><?= __('Edit Budget') ?></legend>
                <?php
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
