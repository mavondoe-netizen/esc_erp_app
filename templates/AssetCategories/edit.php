<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetCategory $assetCategory
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assetCategory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assetCategory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Asset Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetCategories form content">
            <?= $this->Form->create($assetCategory) ?>
            <fieldset>
                <legend><?= __('Edit Asset Category') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('default_useful_life');
                    echo $this->Form->control('depreciation_method');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
