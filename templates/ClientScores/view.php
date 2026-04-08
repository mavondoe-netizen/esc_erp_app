<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientScore $clientScore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Client Score'), ['action' => 'edit', $clientScore->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Client Score'), ['action' => 'delete', $clientScore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientScore->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Client Scores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Client Score'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="clientScores view content">
            <h3><?= h($clientScore->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Grade') ?></th>
                    <td><?= h($clientScore->grade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk Level') ?></th>
                    <td><?= h($clientScore->risk_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($clientScore->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Client Id') ?></th>
                    <td><?= $this->Number->format($clientScore->client_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score') ?></th>
                    <td><?= $this->Number->format($clientScore->score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Debt Ratio') ?></th>
                    <td><?= $clientScore->debt_ratio === null ? '' : $this->Number->format($clientScore->debt_ratio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Repayment History Score') ?></th>
                    <td><?= $clientScore->repayment_history_score === null ? '' : $this->Number->format($clientScore->repayment_history_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Delinquency Score') ?></th>
                    <td><?= $clientScore->delinquency_score === null ? '' : $this->Number->format($clientScore->delinquency_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active Loans Count') ?></th>
                    <td><?= $this->Number->format($clientScore->active_loans_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Computed At') ?></th>
                    <td><?= h($clientScore->computed_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($clientScore->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($clientScore->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>