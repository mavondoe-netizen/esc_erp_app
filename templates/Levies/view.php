<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Levy $levy
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Levy'), ['action' => 'edit', $levy->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Levy'), ['action' => 'delete', $levy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $levy->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Levies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Levy'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="levies view content">
            <h3><?= h($levy->levy_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $levy->hasValue('company') ? $this->Html->link($levy->company->name, ['controller' => 'Companies', 'action' => 'view', $levy->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Enrolment') ?></th>
                    <td><?= $levy->hasValue('enrolment') ? $this->Html->link($levy->enrolment->id, ['controller' => 'Enrolments', 'action' => 'view', $levy->enrolment->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $levy->hasValue('tenant') ? $this->Html->link($levy->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $levy->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= $levy->hasValue('unit') ? $this->Html->link($levy->unit->name, ['controller' => 'Units', 'action' => 'view', $levy->unit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Building') ?></th>
                    <td><?= $levy->hasValue('building') ? $this->Html->link($levy->building->name, ['controller' => 'Buildings', 'action' => 'view', $levy->building->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Levy Type') ?></th>
                    <td><?= h($levy->levy_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($levy->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $levy->hasValue('account') ? $this->Html->link($levy->account->name, ['controller' => 'Accounts', 'action' => 'view', $levy->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($levy->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($levy->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($levy->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid Date') ?></th>
                    <td><?= h($levy->paid_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($levy->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($levy->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid') ?></th>
                    <td><?= $levy->paid ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($levy->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>