<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditAction $auditAction
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audit Actions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditActions form content">
            <?= $this->Form->create($auditAction) ?>
            <fieldset>
                <legend><?= __('Add Audit Action') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('finding_id');
                    echo $this->Form->control('assigned_to');
                    echo $this->Form->control('due_date', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('completion_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
