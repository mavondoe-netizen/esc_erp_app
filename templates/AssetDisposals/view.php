<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetDisposal $assetDisposal
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Disposal'), ['action' => 'edit', $assetDisposal->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Disposal'), ['action' => 'delete', $assetDisposal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDisposal->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Disposals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Disposal'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetDisposals view content">
            <h3><?= h($assetDisposal->disposal_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetDisposal->hasValue('company') ? $this->Html->link($assetDisposal->company->name, ['controller' => 'Companies', 'action' => 'view', $assetDisposal->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetDisposal->hasValue('asset') ? $this->Html->link($assetDisposal->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetDisposal->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Disposal Type') ?></th>
                    <td><?= h($assetDisposal->disposal_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetDisposal->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disposal Amount') ?></th>
                    <td><?= $this->Number->format($assetDisposal->disposal_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gain Or Loss') ?></th>
                    <td><?= $assetDisposal->gain_or_loss === null ? '' : $this->Number->format($assetDisposal->gain_or_loss) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $assetDisposal->approved_by === null ? '' : $this->Number->format($assetDisposal->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disposal Date') ?></th>
                    <td><?= h($assetDisposal->disposal_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetDisposal->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetDisposal->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>