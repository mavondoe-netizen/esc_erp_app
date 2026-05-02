<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalFlow $approvalFlow
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Approval Flows'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalFlows form content">
            <?= $this->Form->create($approvalFlow) ?>
            <fieldset>
                <legend><?= __('Add Approval Flow') ?></legend>
                <?php
                    echo $this->Form->control('module_name', ['options' => $modules, 'label' => 'Module/Entity']);
                    echo $this->Form->control('level', ['label' => 'Approval Level (1, 2, 3...)']);
                    echo $this->Form->control('role_id', ['options' => $roles, 'label' => 'Approver Role']);
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
