<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisition
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Requisition'), ['action' => 'edit', $requisition->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Requisition'), ['action' => 'delete', $requisition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requisition->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Requisitions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Requisition'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="requisitions view content">
            <h3><?= h($requisition->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= $requisition->hasValue('department') ? $this->Html->link($requisition->department->name, ['controller' => 'Departments', 'action' => 'view', $requisition->department->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $requisition->hasValue('user') ? $this->Html->link($requisition->user->role_id, ['controller' => 'Users', 'action' => 'view', $requisition->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($requisition->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $requisition->hasValue('company') ? $this->Html->link($requisition->company->name, ['controller' => 'Companies', 'action' => 'view', $requisition->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($requisition->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Estimated Cost') ?></th>
                    <td><?= $requisition->total_estimated_cost === null ? '' : $this->Number->format($requisition->total_estimated_cost) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($requisition->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($requisition->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($requisition->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Procurements') ?></h4>
                <?php if (!empty($requisition->procurements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Procurement Method') ?></th>
                            <th><?= __('Assigned To') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($requisition->procurements as $procurement) : ?>
                        <tr>
                            <td><?= h($procurement->id) ?></td>
                            <td><?= h($procurement->procurement_method) ?></td>
                            <td><?= h($procurement->assigned_to) ?></td>
                            <td><?= h($procurement->status) ?></td>
                            <td><?= h($procurement->company_id) ?></td>
                            <td><?= h($procurement->created) ?></td>
                            <td><?= h($procurement->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Procurements', 'action' => 'view', $procurement->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Procurements', 'action' => 'edit', $procurement->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Procurements', 'action' => 'delete', $procurement->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $procurement->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Requisition Items') ?></h4>
                <?php if (!empty($requisition->requisition_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Item Description') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Estimated Unit Price') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($requisition->requisition_items as $requisitionItem) : ?>
                        <tr>
                            <td><?= h($requisitionItem->id) ?></td>
                            <td><?= h($requisitionItem->item_description) ?></td>
                            <td><?= h($requisitionItem->quantity) ?></td>
                            <td><?= h($requisitionItem->estimated_unit_price) ?></td>
                            <td><?= h($requisitionItem->company_id) ?></td>
                            <td><?= h($requisitionItem->created) ?></td>
                            <td><?= h($requisitionItem->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RequisitionItems', 'action' => 'view', $requisitionItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RequisitionItems', 'action' => 'edit', $requisitionItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'RequisitionItems', 'action' => 'delete', $requisitionItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $requisitionItem->id),
                                    ]
                                ) ?>
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