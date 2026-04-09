<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetDepreciation $assetDepreciation
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $assets
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assetDepreciation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assetDepreciation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Asset Depreciation'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetDepreciation form content">
            <?= $this->Form->create($assetDepreciation) ?>
            <fieldset>
                <legend><?= __('Edit Asset Depreciation') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('period');
                    echo $this->Form->control('depreciation_amount');
                    echo $this->Form->control('accumulated_depreciation');
                    echo $this->Form->control('book_value');
                    echo $this->Form->control('posted_to_ledger');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
