<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetClassification $assetClassification
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Classification'), ['action' => 'edit', $assetClassification->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Classification'), ['action' => 'delete', $assetClassification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetClassification->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Classifications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Classification'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetClassifications view content">
            <h3><?= h($assetClassification->type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetClassification->hasValue('company') ? $this->Html->link($assetClassification->company->name, ['controller' => 'Companies', 'action' => 'view', $assetClassification->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($assetClassification->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetClassification->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetClassification->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetClassification->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Accounting Treatment') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($assetClassification->accounting_treatment)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>