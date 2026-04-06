<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meeting $meeting
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Meeting'), ['action' => 'edit', $meeting->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Meeting'), ['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Meetings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Meeting'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="meetings view content">
            <h3><?= h($meeting->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($meeting->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact') ?></th>
                    <td><?= $meeting->hasValue('contact') ? $this->Html->link($meeting->contact->name, ['controller' => 'Contacts', 'action' => 'view', $meeting->contact->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $meeting->hasValue('user') ? $this->Html->link($meeting->user->email, ['controller' => 'Users', 'action' => 'view', $meeting->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Agenda') ?></th>
                    <td><?= h($meeting->agenda) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outcomes') ?></th>
                    <td><?= h($meeting->outcomes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Attachments') ?></th>
                    <td><?= h($meeting->attachments) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($meeting->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>