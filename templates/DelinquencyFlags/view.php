<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DelinquencyFlag $delinquencyFlag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Delinquency Flag'), ['action' => 'edit', $delinquencyFlag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Delinquency Flag'), ['action' => 'delete', $delinquencyFlag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $delinquencyFlag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Delinquency Flags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Delinquency Flag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="delinquencyFlags view content">
            <h3><?= h($delinquencyFlag->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $delinquencyFlag->hasValue('loan') ? $this->Html->link($delinquencyFlag->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $delinquencyFlag->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($delinquencyFlag->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($delinquencyFlag->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($delinquencyFlag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days Overdue') ?></th>
                    <td><?= $this->Number->format($delinquencyFlag->days_overdue) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount Overdue') ?></th>
                    <td><?= $this->Number->format($delinquencyFlag->amount_overdue) ?></td>
                </tr>
                <tr>
                    <th><?= __('Flagged At') ?></th>
                    <td><?= h($delinquencyFlag->flagged_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resolved At') ?></th>
                    <td><?= h($delinquencyFlag->resolved_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($delinquencyFlag->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($delinquencyFlag->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Notification Sent') ?></th>
                    <td><?= $delinquencyFlag->notification_sent ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($delinquencyFlag->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>