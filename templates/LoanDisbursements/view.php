<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanDisbursement $loanDisbursement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Disbursement'), ['action' => 'edit', $loanDisbursement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Disbursement'), ['action' => 'delete', $loanDisbursement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDisbursement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Disbursements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Disbursement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanDisbursements view content">
            <h3><?= h($loanDisbursement->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanDisbursement->hasValue('loan') ? $this->Html->link($loanDisbursement->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanDisbursement->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanDisbursement->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Method') ?></th>
                    <td><?= h($loanDisbursement->method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Reference') ?></th>
                    <td><?= h($loanDisbursement->bank_reference) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $loanDisbursement->hasValue('account') ? $this->Html->link($loanDisbursement->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanDisbursement->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanDisbursement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($loanDisbursement->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disbursed By') ?></th>
                    <td><?= $loanDisbursement->disbursed_by === null ? '' : $this->Number->format($loanDisbursement->disbursed_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disbursed At') ?></th>
                    <td><?= h($loanDisbursement->disbursed_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanDisbursement->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanDisbursement->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanDisbursement->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>