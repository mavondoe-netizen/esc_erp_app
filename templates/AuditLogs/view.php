<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditLog $auditLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Log'), ['action' => 'edit', $auditLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Log'), ['action' => 'delete', $auditLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditLogs view content">
            <h3><?= h($auditLog->model) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td>
                        <?= $auditLog->user_id ?>
                        <?php if (!empty($user)): ?>
                            (<?= $this->Html->link($user->email, ['controller' => 'Users', 'action' => 'view', $user->id]) ?>)
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($auditLog->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Record Id') ?></th>
                    <td><?= h($auditLog->record_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($auditLog->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $auditLog->hasValue('company') ? $this->Html->link($auditLog->company->name, ['controller' => 'Companies', 'action' => 'view', $auditLog->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auditLog->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Changed Data') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditLog->changed_data)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>