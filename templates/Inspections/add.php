<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $inspectors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inspections'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspections form content">
            <?= $this->Form->create($inspection) ?>
            <fieldset>
                <legend><?= __('Add Inspection') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('customer_id', ['options' => $customers]);
                    echo $this->Form->control('date');
                    echo $this->Form->control('pobs_insurable');
                    echo $this->Form->control('apwcs_insurable');
                    echo $this->Form->control('apwcs_penalty');
                    echo $this->Form->control('inspector_id', ['options' => $inspectors]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
