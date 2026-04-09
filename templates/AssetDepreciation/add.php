<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetDepreciation $assetDepreciation
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $assets
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asset Depreciation'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetDepreciation form content">
            <?= $this->Form->create($assetDepreciation) ?>
            <fieldset>
                <legend><?= __('Add Asset Depreciation') ?></legend>
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
