<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditFinding $auditFinding
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $audits
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audit Findings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditFindings form content">
            <?= $this->Form->create($auditFinding) ?>
            <fieldset>
                <legend><?= __('Add Audit Finding') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('audit_id', ['options' => $audits]);
                    echo $this->Form->control('finding');
                    echo $this->Form->control('risk_level');
                    echo $this->Form->control('root_cause');
                    echo $this->Form->control('recommendation');
                    echo $this->Form->control('management_response');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
