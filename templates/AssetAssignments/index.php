<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetAssignment> $assetAssignments
 */
?>
<div class="assetAssignments index content">
    <?= $this->Html->link(__('New Asset Assignment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Assignments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('office_id') ?></th>
                    <th><?= $this->Paginator->sort('department_id') ?></th>
                    <th><?= $this->Paginator->sort('assigned_to') ?></th>
                    <th><?= $this->Paginator->sort('assigned_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetAssignments as $assetAssignment): ?>
                <tr>
                    <td><?= $this->Number->format($assetAssignment->id) ?></td>
                    <td><?= $assetAssignment->hasValue('company') ? $this->Html->link($assetAssignment->company->name, ['controller' => 'Companies', 'action' => 'view', $assetAssignment->company->id]) : '' ?></td>
                    <td><?= $assetAssignment->hasValue('asset') ? $this->Html->link($assetAssignment->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetAssignment->asset->id]) : '' ?></td>
                    <td><?= $assetAssignment->hasValue('office') ? $this->Html->link($assetAssignment->office->name, ['controller' => 'Offices', 'action' => 'view', $assetAssignment->office->id]) : '' ?></td>
                    <td><?= $assetAssignment->hasValue('department') ? $this->Html->link($assetAssignment->department->name, ['controller' => 'Departments', 'action' => 'view', $assetAssignment->department->id]) : '' ?></td>
                    <td><?= $assetAssignment->assigned_to === null ? '' : $this->Number->format($assetAssignment->assigned_to) ?></td>
                    <td><?= h($assetAssignment->assigned_date) ?></td>
                    <td><?= h($assetAssignment->status) ?></td>
                    <td><?= h($assetAssignment->created) ?></td>
                    <td><?= h($assetAssignment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetAssignment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetAssignment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetAssignment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetAssignment->id)]) ?>
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