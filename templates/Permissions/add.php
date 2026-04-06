<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Permissions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="permissions form content">
            <?= $this->Form->create($permission) ?>
            <fieldset>
                <legend><?= __('Add Permission') ?></legend>
                <?php
                    echo $this->Form->control('role_id', ['options' => $roles]);
                    echo $this->Form->control('model',['options' => $modelsOptions]);
                    echo $this->Form->control('can_create');
                    echo $this->Form->control('can_read');
                    echo $this->Form->control('can_update');
                    echo $this->Form->control('can_delete');
                    echo $this->Form->control('can_approve');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
