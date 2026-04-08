<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Control $control
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $risks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $control->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $control->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Controls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="controls form content">
            <?= $this->Form->create($control) ?>
            <fieldset>
                <legend><?= __('Edit Control') ?></legend>
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
