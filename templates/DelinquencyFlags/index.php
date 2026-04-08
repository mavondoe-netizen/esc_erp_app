<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DelinquencyFlag> $delinquencyFlags
 */
?>
<div class="delinquencyFlags index content">
    <?= $this->Html->link(__('New Delinquency Flag'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Delinquency Flags') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('days_overdue') ?></th>
                    <th><?= $this->Paginator->sort('amount_overdue') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('flagged_at') ?></th>
                    <th><?= $this->Paginator->sort('resolved_at') ?></th>
                    <th><?= $this->Paginator->sort('notification_sent') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($delinquencyFlags as $delinquencyFlag): ?>
                <tr>
                    <td><?= $this->Number->format($delinquencyFlag->id) ?></td>
                    <td><?= $delinquencyFlag->hasValue('loan') ? $this->Html->link($delinquencyFlag->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $delinquencyFlag->loan->id]) : '' ?></td>
                    <td><?= $this->Number->format($delinquencyFlag->days_overdue) ?></td>
                    <td><?= $this->Number->format($delinquencyFlag->amount_overdue) ?></td>
                    <td><?= h($delinquencyFlag->currency) ?></td>
                    <td><?= h($delinquencyFlag->category) ?></td>
                    <td><?= h($delinquencyFlag->flagged_at) ?></td>
                    <td><?= h($delinquencyFlag->resolved_at) ?></td>
                    <td><?= h($delinquencyFlag->notification_sent) ?></td>
                    <td><?= h($delinquencyFlag->created) ?></td>
                    <td><?= h($delinquencyFlag->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $delinquencyFlag->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $delinquencyFlag->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $delinquencyFlag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $delinquencyFlag->id)]) ?>
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