<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Accounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="accounts form content">
            <?= $this->Form->create($account) ?>
            <fieldset>
                <legend><?= __('Add Account') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('category', ['options' => $categories, 'empty' => 'Select Category']);
                    echo $this->Form->control('type', ['options' => $types, 'empty' => 'Select Type']);
                    echo $this->Form->control('subcategory', ['options' => $subcategories, 'empty' => 'Select Subcategory']);
                    echo $this->Form->control('opening_balance', ['label' => 'Opening Balance (Base Currency)', 'step' => '0.01']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
