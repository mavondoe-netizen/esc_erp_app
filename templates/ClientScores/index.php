<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ClientScore> $clientScores
 */
?>
<div class="clientScores index content">
    <?= $this->Html->link(__('New Client Score'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Client Scores') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('grade') ?></th>
                    <th><?= $this->Paginator->sort('risk_level') ?></th>
                    <th><?= $this->Paginator->sort('debt_ratio') ?></th>
                    <th><?= $this->Paginator->sort('repayment_history_score') ?></th>
                    <th><?= $this->Paginator->sort('delinquency_score') ?></th>
                    <th><?= $this->Paginator->sort('active_loans_count') ?></th>
                    <th><?= $this->Paginator->sort('computed_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientScores as $clientScore): ?>
                <tr>
                    <td><?= $this->Number->format($clientScore->id) ?></td>
                    <td><?= $this->Number->format($clientScore->client_id) ?></td>
                    <td><?= $this->Number->format($clientScore->score) ?></td>
                    <td><?= h($clientScore->grade) ?></td>
                    <td><?= h($clientScore->risk_level) ?></td>
                    <td><?= $clientScore->debt_ratio === null ? '' : $this->Number->format($clientScore->debt_ratio) ?></td>
                    <td><?= $clientScore->repayment_history_score === null ? '' : $this->Number->format($clientScore->repayment_history_score) ?></td>
                    <td><?= $clientScore->delinquency_score === null ? '' : $this->Number->format($clientScore->delinquency_score) ?></td>
                    <td><?= $this->Number->format($clientScore->active_loans_count) ?></td>
                    <td><?= h($clientScore->computed_at) ?></td>
                    <td><?= h($clientScore->created) ?></td>
                    <td><?= h($clientScore->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $clientScore->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientScore->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientScore->id)]) ?>
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