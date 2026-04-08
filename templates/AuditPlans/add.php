<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditPlan $auditPlan
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audit Plans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditPlans form content">
            <?= $this->Form->create($auditPlan) ?>
            <fieldset>
                <legend><?= __('Add Audit Plan') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('year');
                    echo $this->Form->control('business_unit_id');
                    echo $this->Form->control('audit_type');
                    echo $this->Form->control('planned_start', ['empty' => true]);
                    echo $this->Form->control('planned_end', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
