<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanWriteoff $loanWriteoff
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Writeoff'), ['action' => 'edit', $loanWriteoff->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Writeoff'), ['action' => 'delete', $loanWriteoff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanWriteoff->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Writeoffs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Writeoff'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanWriteoffs view content">
            <h3><?= h($loanWriteoff->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanWriteoff->hasValue('loan') ? $this->Html->link($loanWriteoff->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanWriteoff->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanWriteoff->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanWriteoff->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $loanWriteoff->hasValue('account') ? $this->Html->link($loanWriteoff->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanWriteoff->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanWriteoff->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($loanWriteoff->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outstanding At Writeoff') ?></th>
                    <td><?= $loanWriteoff->outstanding_at_writeoff === null ? '' : $this->Number->format($loanWriteoff->outstanding_at_writeoff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $loanWriteoff->approved_by === null ? '' : $this->Number->format($loanWriteoff->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved At') ?></th>
                    <td><?= h($loanWriteoff->approved_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanWriteoff->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanWriteoff->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Reason') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanWriteoff->reason)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>