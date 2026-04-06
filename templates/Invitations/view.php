<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invitation $invitation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invitation'), ['action' => 'edit', $invitation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invitation'), ['action' => 'delete', $invitation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invitations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invitation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invitations view content">
            <h3><?= h($invitation->email) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($invitation->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $invitation->hasValue('company') ? $this->Html->link($invitation->company->name, ['controller' => 'Companies', 'action' => 'view', $invitation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $invitation->hasValue('role') ? $this->Html->link($invitation->role->name, ['controller' => 'Roles', 'action' => 'view', $invitation->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($invitation->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invitation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invitation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invitation->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>