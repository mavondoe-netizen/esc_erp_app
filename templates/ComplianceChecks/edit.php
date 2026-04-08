<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComplianceCheck $complianceCheck
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $complianceCheck->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $complianceCheck->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Compliance Checks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complianceChecks form content">
            <?= $this->Form->create($complianceCheck) ?>
            <fieldset>
                <legend><?= __('Edit Compliance Check') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('obligation_id');
                    echo $this->Form->control('status');
                    echo $this->Form->control('evidence');
                    echo $this->Form->control('checked_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
