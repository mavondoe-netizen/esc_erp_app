<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetLog> $assetLogs
 */
?>
<div class="assetLogs index content">
    <?= $this->Html->link(__('New Asset Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetLogs as $assetLog): ?>
                <tr>
                    <td><?= $this->Number->format($assetLog->id) ?></td>
                    <td><?= $assetLog->hasValue('company') ? $this->Html->link($assetLog->company->name, ['controller' => 'Companies', 'action' => 'view', $assetLog->company->id]) : '' ?></td>
                    <td><?= $assetLog->hasValue('asset') ? $this->Html->link($assetLog->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetLog->asset->id]) : '' ?></td>
                    <td><?= h($assetLog->action) ?></td>
                    <td><?= $assetLog->hasValue('user') ? $this->Html->link($assetLog->user->role_id, ['controller' => 'Users', 'action' => 'view', $assetLog->user->id]) : '' ?></td>
                    <td><?= h($assetLog->timestamp) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetLog->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>