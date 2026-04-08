<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Control $control
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $risks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Controls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="controls form content">
            <?= $this->Form->create($control) ?>
            <fieldset>
                <legend><?= __('Add Control') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('risk_id', ['options' => $risks, 'empty' => true]);
                    echo $this->Form->control('control_name');
                    echo $this->Form->control('control_type');
                    echo $this->Form->control('frequency');
                    echo $this->Form->control('owner_id');
                    echo $this->Form->control('effectiveness_rating');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
