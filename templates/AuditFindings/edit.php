<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditFinding $auditFinding
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $audits
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $auditFinding->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $auditFinding->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Audit Findings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditFindings form content">
            <?= $this->Form->create($auditFinding) ?>
            <fieldset>
                <legend><?= __('Edit Audit Finding') ?></legend>
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
