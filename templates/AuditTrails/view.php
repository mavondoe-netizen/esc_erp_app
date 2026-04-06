<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditTrail $auditTrail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Trail'), ['action' => 'edit', $auditTrail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Trail'), ['action' => 'delete', $auditTrail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditTrail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Trails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Trail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditTrails view content">
            <h3><?= h($auditTrail->entity_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Entity Type') ?></th>
                    <td><?= h($auditTrail->entity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($auditTrail->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($auditTrail->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $auditTrail->hasValue('user') ? $this->Html->link($auditTrail->user->email, ['controller' => 'Users', 'action' => 'view', $auditTrail->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditTrail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Id') ?></th>
                    <td><?= $this->Number->format($auditTrail->entity_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auditTrail->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>