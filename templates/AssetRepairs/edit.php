<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetRepair $assetRepair
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
                ['action' => 'delete', $assetRepair->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assetRepair->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Asset Repairs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetRepairs form content">
            <?= $this->Form->create($assetRepair) ?>
            <fieldset>
                <legend><?= __('Edit Asset Repair') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('issue_description');
                    echo $this->Form->control('repair_type');
                    echo $this->Form->control('vendor');
                    echo $this->Form->control('cost');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('end_date', ['empty' => true]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
