<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditLog $auditLog
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $auditLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $auditLog->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Audit Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditLogs form content">
            <?= $this->Form->create($auditLog) ?>
            <fieldset>
                <legend><?= __('Edit Audit Log') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('model');
                    echo $this->Form->control('record_id');
                    echo $this->Form->control('action');
                    echo $this->Form->control('changed_data');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
