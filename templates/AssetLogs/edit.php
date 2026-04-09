<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetLog $assetLog
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $assets
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assetLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assetLog->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Asset Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetLogs form content">
            <?= $this->Form->create($assetLog) ?>
            <fieldset>
                <legend><?= __('Edit Asset Log') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('asset_id', ['options' => $assets]);
                    echo $this->Form->control('action');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('timestamp');
                    echo $this->Form->control('details');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
