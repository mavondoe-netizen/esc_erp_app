<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Repair $repair
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Repair'), ['action' => 'edit', $repair->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Repair'), ['action' => 'delete', $repair->id], ['confirm' => __('Are you sure you want to delete # {0}?', $repair->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Repairs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Repair'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="repairs view content">
            <h3><?= h($repair->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $repair->hasValue('company') ? $this->Html->link($repair->company->name, ['controller' => 'Companies', 'action' => 'view', $repair->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= $repair->hasValue('unit') ? $this->Html->link($repair->unit->name, ['controller' => 'Units', 'action' => 'view', $repair->unit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Building') ?></th>
                    <td><?= $repair->hasValue('building') ? $this->Html->link($repair->building->name, ['controller' => 'Buildings', 'action' => 'view', $repair->building->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $repair->hasValue('tenant') ? $this->Html->link($repair->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $repair->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($repair->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($repair->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($repair->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($repair->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $repair->hasValue('account') ? $this->Html->link($repair->account->name, ['controller' => 'Accounts', 'action' => 'view', $repair->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($repair->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cost') ?></th>
                    <td><?= $repair->cost === null ? '' : $this->Number->format($repair->cost) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reported Date') ?></th>
                    <td><?= h($repair->reported_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resolved Date') ?></th>
                    <td><?= h($repair->resolved_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($repair->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($repair->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($repair->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>