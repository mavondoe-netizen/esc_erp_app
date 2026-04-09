<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset $asset
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset'), ['action' => 'edit', $asset->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Assets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assets view content">
            <h3><?= h($asset->asset_tag) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $asset->hasValue('company') ? $this->Html->link($asset->company->name, ['controller' => 'Companies', 'action' => 'view', $asset->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset Tag') ?></th>
                    <td><?= h($asset->asset_tag) ?></td>
                </tr>
                <tr>
                    <th><?= __('Depreciation Method') ?></th>
                    <td><?= h($asset->depreciation_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($asset->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Office') ?></th>
                    <td><?= $asset->hasValue('office') ? $this->Html->link($asset->office->name, ['controller' => 'Offices', 'action' => 'view', $asset->office->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($asset->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category Id') ?></th>
                    <td><?= $asset->category_id === null ? '' : $this->Number->format($asset->category_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Classification Id') ?></th>
                    <td><?= $asset->classification_id === null ? '' : $this->Number->format($asset->classification_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acquisition Cost') ?></th>
                    <td><?= $asset->acquisition_cost === null ? '' : $this->Number->format($asset->acquisition_cost) ?></td>
                </tr>
                <tr>
                    <th><?= __('Useful Life') ?></th>
                    <td><?= $asset->useful_life === null ? '' : $this->Number->format($asset->useful_life) ?></td>
                </tr>
                <tr>
                    <th><?= __('Residual Value') ?></th>
                    <td><?= $this->Number->format($asset->residual_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Current Book Value') ?></th>
                    <td><?= $asset->current_book_value === null ? '' : $this->Number->format($asset->current_book_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assigned To') ?></th>
                    <td><?= $asset->assigned_to === null ? '' : $this->Number->format($asset->assigned_to) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acquisition Date') ?></th>
                    <td><?= h($asset->acquisition_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($asset->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($asset->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($asset->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Asset Assignments') ?></h4>
                <?php if (!empty($asset->asset_assignments)) : ?>
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
                        <?php foreach ($asset->asset_assignments as $assetAssignment) : ?>
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
                <h4><?= __('Related Asset Depreciation') ?></h4>
                <?php if (!empty($asset->asset_depreciation)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('Period') ?></th>
                            <th><?= __('Depreciation Amount') ?></th>
                            <th><?= __('Accumulated Depreciation') ?></th>
                            <th><?= __('Book Value') ?></th>
                            <th><?= __('Posted To Ledger') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($asset->asset_depreciation as $assetDepreciation) : ?>
                        <tr>
                            <td><?= h($assetDepreciation->id) ?></td>
                            <td><?= h($assetDepreciation->company_id) ?></td>
                            <td><?= h($assetDepreciation->asset_id) ?></td>
                            <td><?= h($assetDepreciation->period) ?></td>
                            <td><?= h($assetDepreciation->depreciation_amount) ?></td>
                            <td><?= h($assetDepreciation->accumulated_depreciation) ?></td>
                            <td><?= h($assetDepreciation->book_value) ?></td>
                            <td><?= h($assetDepreciation->posted_to_ledger) ?></td>
                            <td><?= h($assetDepreciation->created) ?></td>
                            <td><?= h($assetDepreciation->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetDepreciation', 'action' => 'view', $assetDepreciation->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetDepreciation', 'action' => 'edit', $assetDepreciation->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetDepreciation', 'action' => 'delete', $assetDepreciation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDepreciation->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asset Disposals') ?></h4>
                <?php if (!empty($asset->asset_disposals)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('Disposal Type') ?></th>
                            <th><?= __('Disposal Date') ?></th>
                            <th><?= __('Disposal Amount') ?></th>
                            <th><?= __('Gain Or Loss') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($asset->asset_disposals as $assetDisposal) : ?>
                        <tr>
                            <td><?= h($assetDisposal->id) ?></td>
                            <td><?= h($assetDisposal->company_id) ?></td>
                            <td><?= h($assetDisposal->asset_id) ?></td>
                            <td><?= h($assetDisposal->disposal_type) ?></td>
                            <td><?= h($assetDisposal->disposal_date) ?></td>
                            <td><?= h($assetDisposal->disposal_amount) ?></td>
                            <td><?= h($assetDisposal->gain_or_loss) ?></td>
                            <td><?= h($assetDisposal->approved_by) ?></td>
                            <td><?= h($assetDisposal->created) ?></td>
                            <td><?= h($assetDisposal->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetDisposals', 'action' => 'view', $assetDisposal->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetDisposals', 'action' => 'edit', $assetDisposal->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetDisposals', 'action' => 'delete', $assetDisposal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDisposal->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asset Logs') ?></h4>
                <?php if (!empty($asset->asset_logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('Action') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th><?= __('Details') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($asset->asset_logs as $assetLog) : ?>
                        <tr>
                            <td><?= h($assetLog->id) ?></td>
                            <td><?= h($assetLog->company_id) ?></td>
                            <td><?= h($assetLog->asset_id) ?></td>
                            <td><?= h($assetLog->action) ?></td>
                            <td><?= h($assetLog->user_id) ?></td>
                            <td><?= h($assetLog->timestamp) ?></td>
                            <td><?= h($assetLog->details) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetLogs', 'action' => 'view', $assetLog->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetLogs', 'action' => 'edit', $assetLog->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetLogs', 'action' => 'delete', $assetLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetLog->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asset Repairs') ?></h4>
                <?php if (!empty($asset->asset_repairs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('Issue Description') ?></th>
                            <th><?= __('Repair Type') ?></th>
                            <th><?= __('Vendor') ?></th>
                            <th><?= __('Cost') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($asset->asset_repairs as $assetRepair) : ?>
                        <tr>
                            <td><?= h($assetRepair->id) ?></td>
                            <td><?= h($assetRepair->company_id) ?></td>
                            <td><?= h($assetRepair->asset_id) ?></td>
                            <td><?= h($assetRepair->issue_description) ?></td>
                            <td><?= h($assetRepair->repair_type) ?></td>
                            <td><?= h($assetRepair->vendor) ?></td>
                            <td><?= h($assetRepair->cost) ?></td>
                            <td><?= h($assetRepair->start_date) ?></td>
                            <td><?= h($assetRepair->end_date) ?></td>
                            <td><?= h($assetRepair->status) ?></td>
                            <td><?= h($assetRepair->created) ?></td>
                            <td><?= h($assetRepair->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetRepairs', 'action' => 'view', $assetRepair->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetRepairs', 'action' => 'edit', $assetRepair->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetRepairs', 'action' => 'delete', $assetRepair->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetRepair->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Asset Transfers') ?></h4>
                <?php if (!empty($asset->asset_transfers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Asset Id') ?></th>
                            <th><?= __('From Office Id') ?></th>
                            <th><?= __('To Office Id') ?></th>
                            <th><?= __('Transfer Date') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($asset->asset_transfers as $assetTransfer) : ?>
                        <tr>
                            <td><?= h($assetTransfer->id) ?></td>
                            <td><?= h($assetTransfer->company_id) ?></td>
                            <td><?= h($assetTransfer->asset_id) ?></td>
                            <td><?= h($assetTransfer->from_office_id) ?></td>
                            <td><?= h($assetTransfer->to_office_id) ?></td>
                            <td><?= h($assetTransfer->transfer_date) ?></td>
                            <td><?= h($assetTransfer->approved_by) ?></td>
                            <td><?= h($assetTransfer->status) ?></td>
                            <td><?= h($assetTransfer->created) ?></td>
                            <td><?= h($assetTransfer->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AssetTransfers', 'action' => 'view', $assetTransfer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AssetTransfers', 'action' => 'edit', $assetTransfer->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AssetTransfers', 'action' => 'delete', $assetTransfer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetTransfer->id)]) ?>
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