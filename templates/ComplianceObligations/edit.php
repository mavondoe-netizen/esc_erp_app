<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComplianceObligation $complianceObligation
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $regulations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $complianceObligation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $complianceObligation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Compliance Obligations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complianceObligations form content">
            <?= $this->Form->create($complianceObligation) ?>
            <fieldset>
                <legend><?= __('Edit Compliance Obligation') ?></legend>
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
