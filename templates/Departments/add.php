<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="departments form content">
            <?= $this->Form->create($department) ?>
            <fieldset>
                <legend><?= __('Add Department') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
