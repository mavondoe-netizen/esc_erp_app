<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaxTable $taxTable
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tax Tables'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="taxTables form content">
            <?= $this->Form->create($taxTable) ?>
            <fieldset>
                <legend><?= __('Add Tax Table') ?></legend>
                <?php
                    echo $this->Form->control('currency');
                    echo $this->Form->control('lower_limit');
                    echo $this->Form->control('upper_limit');
                    echo $this->Form->control('rate');
                    echo $this->Form->control('deduction');
                    echo $this->Form->control('tax_year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
