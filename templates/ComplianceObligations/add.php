<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComplianceObligation $complianceObligation
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $regulations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Compliance Obligations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complianceObligations form content">
            <?= $this->Form->create($complianceObligation) ?>
            <fieldset>
                <legend><?= __('Add Compliance Obligation') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('regulation_id', ['options' => $regulations]);
                    echo $this->Form->control('requirement');
                    echo $this->Form->control('frequency');
                    echo $this->Form->control('owner_id');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
