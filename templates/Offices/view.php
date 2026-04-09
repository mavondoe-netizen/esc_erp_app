<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Office $office
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Office'), ['action' => 'edit', $office->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Office'), ['action' => 'delete', $office->id], ['confirm' => __('Are you sure you want to delete # {0}?', $office->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Offices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Office'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="offices view content">
            <h3><?= h($office->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $office->hasValue('company') ? $this->Html->link($office->company->name, ['controller' => 'Companies', 'action' => 'view', $office->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($office->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($office->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($office->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($office->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($office->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Asset Assignments') ?></h4>
                <?php if (!empty($office->asset_assignments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('Office Id') ?></th>
                            <th><?= __('Department Id') ?></th>
                            <th><?= __('Assigned To') ?></th>
                            <th><?= __('Assigned Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($office->asset_assignments as $assetAssignment) : ?>
                        <tr>
                            <td><?= h($assetAssignment->id) ?></td>
                            <td><?= h($assetAssignment->company_id) ?></td>
                            <td><?= h($assetAssignment->asset_id) ?></td>
                            <td><?= h($assetAssignment->office_id) ?></td>
                            <td><?= h($assetAssignment->department_id) ?></td>
                            <td><?= h($assetAssignment->assigned_to) ?></td>
                            <td><?= h($assetAssignment->assigned_date) ?></td>
                            <td><?= h($assetAssignment->status) ?></td>
                            <td><?= h($assetAssignment->created) ?></td>
                            <td><?= h($assetAssignment->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetAssignments', 'action' => 'view', $assetAssignment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetAssignments', 'action' => 'edit', $assetAssignment->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetAssignments', 'action' => 'delete', $assetAssignment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetAssignment->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Assets') ?></h4>
                <?php if (!empty($office->assets)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Tag') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('Classification Id') ?></th>
                            <th><?= __('Acquisition Date') ?></th>
                            <th><?= __('Acquisition Cost') ?></th>
                            <th><?= __('Useful Life') ?></th>
                            <th><?= __('Depreciation Method') ?></th>
                            <th><?= __('Residual Value') ?></th>
                            <th><?= __('Current Book Value') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Office Id') ?></th>
                            <th><?= __('Assigned To') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($office->assets as $asset) : ?>
                        <tr>
                            <td><?= h($asset->id) ?></td>
                            <td><?= h($asset->company_id) ?></td>
                            <td><?= h($asset->asset_tag) ?></td>
                            <td><?= h($asset->description) ?></td>
                            <td><?= h($asset->category_id) ?></td>
                            <td><?= h($asset->classification_id) ?></td>
                            <td><?= h($asset->acquisition_date) ?></td>
                            <td><?= h($asset->acquisition_cost) ?></td>
                            <td><?= h($asset->useful_life) ?></td>
                            <td><?= h($asset->depreciation_method) ?></td>
                            <td><?= h($asset->residual_value) ?></td>
                            <td><?= h($asset->current_book_value) ?></td>
                            <td><?= h($asset->status) ?></td>
                            <td><?= h($asset->office_id) ?></td>
                            <td><?= h($asset->assigned_to) ?></td>
                            <td><?= h($asset->created) ?></td>
                            <td><?= h($asset->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Assets', 'action' => 'view', $asset->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Assets', 'action' => 'edit', $asset->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Assets', 'action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>