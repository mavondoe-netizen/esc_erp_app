<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Meeting> $meetings
 */
?>
<div class="meetings index content">
    <?= $this->Html->link(__('New Meeting'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Meetings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('contact_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('agenda') ?></th>
                    <th><?= $this->Paginator->sort('outcomes') ?></th>
                    <th><?= $this->Paginator->sort('attachments') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meetings as $meeting): ?>
                <tr>
                    <td><?= $this->Number->format($meeting->id) ?></td>
                    <td><?= h($meeting->name) ?></td>
                    <td><?= $meeting->hasValue('contact') ? $this->Html->link($meeting->contact->name, ['controller' => 'Contacts', 'action' => 'view', $meeting->contact->id]) : '' ?></td>
                    <td><?= $meeting->hasValue('user') ? $this->Html->link($meeting->user->email, ['controller' => 'Users', 'action' => 'view', $meeting->user->id]) : '' ?></td>
                    <td><?= h($meeting->agenda) ?></td>
                    <td><?= h($meeting->outcomes) ?></td>
                    <td><?= h($meeting->attachments) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $meeting->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $meeting->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>