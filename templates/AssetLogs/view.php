<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetLog $assetLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Log'), ['action' => 'edit', $assetLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Log'), ['action' => 'delete', $assetLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetLogs view content">
            <h3><?= h($assetLog->action) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetLog->hasValue('company') ? $this->Html->link($assetLog->company->name, ['controller' => 'Companies', 'action' => 'view', $assetLog->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetLog->hasValue('asset') ? $this->Html->link($assetLog->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetLog->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($assetLog->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $assetLog->hasValue('user') ? $this->Html->link($assetLog->user->role_id, ['controller' => 'Users', 'action' => 'view', $assetLog->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($assetLog->timestamp) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Details') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($assetLog->details)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>