<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procurement $procurement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Procurement'), ['action' => 'edit', $procurement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Procurement'), ['action' => 'delete', $procurement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $procurement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Procurements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Procurement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="procurements view content">
            <h3><?= h($procurement->procurement_method) ?></h3>
            <table>
                <tr>
                    <th><?= __('Requisition') ?></th>
                    <td><?= $procurement->hasValue('requisition') ? $this->Html->link($procurement->requisition->id, ['controller' => 'Requisitions', 'action' => 'view', $procurement->requisition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Procurement Method') ?></th>
                    <td><?= h($procurement->procurement_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $procurement->hasValue('user') ? $this->Html->link($procurement->user->role_id, ['controller' => 'Users', 'action' => 'view', $procurement->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($procurement->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $procurement->hasValue('company') ? $this->Html->link($procurement->company->name, ['controller' => 'Companies', 'action' => 'view', $procurement->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($procurement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($procurement->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($procurement->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Tenders') ?></h4>
                <?php if (!empty($procurement->tenders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Closing Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($procurement->tenders as $tender) : ?>
                        <tr>
                            <td><?= h($tender->id) ?></td>
                            <td><?= h($tender->title) ?></td>
                            <td><?= h($tender->description) ?></td>
                            <td><?= h($tender->closing_date) ?></td>
                            <td><?= h($tender->status) ?></td>
                            <td><?= h($tender->company_id) ?></td>
                            <td><?= h($tender->created) ?></td>
                            <td><?= h($tender->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tenders', 'action' => 'view', $tender->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tenders', 'action' => 'edit', $tender->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Tenders', 'action' => 'delete', $tender->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $tender->id),
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