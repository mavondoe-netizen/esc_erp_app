<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetTransfer $assetTransfer
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $assets
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asset Transfers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetTransfers form content">
            <?= $this->Form->create($assetTransfer) ?>
            <fieldset>
                <legend><?= __('Add Asset Transfer') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('from_office_id');
                    echo $this->Form->control('to_office_id');
                    echo $this->Form->control('transfer_date');
                    echo $this->Form->control('approved_by');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
