<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetCategory $assetCategory
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asset Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetCategories form content">
            <?= $this->Form->create($assetCategory) ?>
            <fieldset>
                <legend><?= __('Add Asset Category') ?></legend>
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
