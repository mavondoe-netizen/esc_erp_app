<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $department->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $department->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="departments form content">
            <?= $this->Form->create($department) ?>
            <fieldset>
                <legend><?= __('Edit Department') ?></legend>
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
