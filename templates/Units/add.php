<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unit $unit
 * @var \Cake\Collection\CollectionInterface|string[] $buildings
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Units'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="units form content">
            <?= $this->Form->create($unit) ?>
            <fieldset>
                <legend><?= __('Add Unit') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('building_id', ['options' => $buildings]);
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
