<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetCategory $assetCategory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Category'), ['action' => 'edit', $assetCategory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Category'), ['action' => 'delete', $assetCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetCategory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetCategories view content">
            <h3><?= h($assetCategory->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetCategory->hasValue('company') ? $this->Html->link($assetCategory->company->name, ['controller' => 'Companies', 'action' => 'view', $assetCategory->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($assetCategory->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Depreciation Method') ?></th>
                    <td><?= h($assetCategory->depreciation_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetCategory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Default Useful Life') ?></th>
                    <td><?= $assetCategory->default_useful_life === null ? '' : $this->Number->format($assetCategory->default_useful_life) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetCategory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetCategory->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>