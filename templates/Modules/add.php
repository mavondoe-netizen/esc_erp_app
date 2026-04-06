<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Modules'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="modules form content">
            <?= $this->Form->create($module) ?>
            <fieldset>
                <legend><?= __('Add Module') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('model', ['options' => $modelsOptions, 'empty' => 'Select a Database Model']);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
