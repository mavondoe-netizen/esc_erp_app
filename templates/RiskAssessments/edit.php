<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RiskAssessment $riskAssessment
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $risks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $riskAssessment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $riskAssessment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Risk Assessments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="riskAssessments form content">
            <?= $this->Form->create($riskAssessment) ?>
            <fieldset>
                <legend><?= __('Edit Risk Assessment') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('risk_id', ['options' => $risks]);
                    echo $this->Form->control('likelihood');
                    echo $this->Form->control('impact');
                    echo $this->Form->control('control_effectiveness');
                    echo $this->Form->control('risk_rating');
                    echo $this->Form->control('assessed_by');
                    echo $this->Form->control('assessed_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
