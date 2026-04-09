<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetAssignment $assetAssignment
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $assets
 * @var \Cake\Collection\CollectionInterface|string[] $offices
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Asset Assignments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetAssignments form content">
            <?= $this->Form->create($assetAssignment) ?>
            <fieldset>
                <legend><?= __('Add Asset Assignment') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('office_id', ['options' => $offices, 'empty' => true]);
                    echo $this->Form->control('department_id', ['options' => $departments, 'empty' => true]);
                    echo $this->Form->control('assigned_to');
                    echo $this->Form->control('assigned_date');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
