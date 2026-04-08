<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Audit $audit
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $auditPlans
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="audits form content">
            <?= $this->Form->create($audit) ?>
            <fieldset>
                <legend><?= __('Add Audit') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('audit_plan_id', ['options' => $auditPlans, 'empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('scope');
                    echo $this->Form->control('auditor_id');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
