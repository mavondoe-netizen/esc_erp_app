<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalLevel $approvalLevel
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $approvalLevel->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $approvalLevel->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Approval Levels'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalLevels form content">
            <?= $this->Form->create($approvalLevel) ?>
            <fieldset>
                <legend><?= __('Edit Approval Level') ?></legend>
                <?php
                    echo $this->Form->control('entity');
                    echo $this->Form->control('level');
                    echo $this->Form->control('role_id', ['options' => $roles]);
                    echo $this->Form->control('min_value');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
