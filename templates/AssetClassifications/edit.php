<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetClassification $assetClassification
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assetClassification->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assetClassification->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Asset Classifications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetClassifications form content">
            <?= $this->Form->create($assetClassification) ?>
            <fieldset>
                <legend><?= __('Edit Asset Classification') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('accounting_treatment');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
