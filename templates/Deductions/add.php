<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deduction $deduction
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var array $zimraOptions
 * @var array $calculationTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Deductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deductions form content">
            <?= $this->Form->create($deduction) ?>
            <fieldset>
                <legend><?= __('Add Deduction') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('statutory');
                    echo $this->Form->control('tax_deductible');
                    echo $this->Form->control('calculation_type', ['options' => $calculationTypes]);
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('zimra_mapping', ['options' => $zimraOptions, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
