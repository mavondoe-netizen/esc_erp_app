<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetDisposal $assetDisposal
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $assets
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asset Disposals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetDisposals form content">
            <?= $this->Form->create($assetDisposal) ?>
            <fieldset>
                <legend><?= __('Add Asset Disposal') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('disposal_type');
                    echo $this->Form->control('disposal_date');
                    echo $this->Form->control('disposal_amount');
                    echo $this->Form->control('gain_or_loss');
                    echo $this->Form->control('approved_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
