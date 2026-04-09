<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset $asset
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $offices
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $asset->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Assets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assets form content">
            <?= $this->Form->create($asset) ?>
            <fieldset>
                <legend><?= __('Edit Asset') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_tag');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category_id');
                    echo $this->Form->control('classification_id');
                    echo $this->Form->control('acquisition_date', ['empty' => true]);
                    echo $this->Form->control('acquisition_cost');
                    echo $this->Form->control('useful_life');
                    echo $this->Form->control('depreciation_method');
                    echo $this->Form->control('residual_value');
                    echo $this->Form->control('current_book_value');
                    echo $this->Form->control('status');
                    echo $this->Form->control('office_id', ['options' => $offices, 'empty' => true]);
                    echo $this->Form->control('assigned_to');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
