<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Deal> $deals
 */
?>
<div class="deals index content">
    <?= $this->Html->link(__('New Deal'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Deals') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('value') ?></th>
                    <th><?= $this->Paginator->sort('stage') ?></th>
                    <th><?= $this->Paginator->sort('contact_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deals as $deal): ?>
                <tr>
                    <td><?= h($deal->name) ?></td>
                    <td><?= h($deal->type) ?></td>
                    <td><?= $this->Number->format($deal->value) ?></td>
                    <td><?= h($deal->stage) ?></td>
                    <td><?= $deal->hasValue('contact') ? $this->Html->link($deal->contact->name, ['controller' => 'Contacts', 'action' => 'view', $deal->contact->id]) : '' ?></td>
                    <td><?= h($deal->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $deal->id]) ?>
                        
                        <?php if ($deal->status !== 'Approved'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $deal->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $deal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deal->id)]) ?>
                        <?php endif; ?>

                        <?php if (strpos((string)$deal->status, 'Pending Approval') !== false): ?>
                            <?= $this->Form->postLink(__('Approve'), ['action' => 'approve', $deal->id], ['confirm' => __('Are you sure you want to approve this deal?'), 'style' => 'color: #27ae60;']) ?>
                            <?= $this->Form->postLink(__('Reject'), ['action' => 'reject', $deal->id], ['confirm' => __('Are you sure you want to reject this deal?'), 'style' => 'color: #e74c3c;']) ?>
                        <?php elseif ($deal->status === 'Draft' || $deal->status === 'Rejected'): ?>
                            <?= $this->Form->postLink(__('Submit'), ['action' => 'requestForApproval', $deal->id]) ?>
                        <?php endif; ?>
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