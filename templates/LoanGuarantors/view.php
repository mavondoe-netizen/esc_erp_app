<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanGuarantor $loanGuarantor
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Guarantor'), ['action' => 'edit', $loanGuarantor->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Guarantor'), ['action' => 'delete', $loanGuarantor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanGuarantor->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Guarantors'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Guarantor'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanGuarantors view content">
            <h3><?= h($loanGuarantor->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan Application') ?></th>
                    <td><?= $loanGuarantor->hasValue('loan_application') ? $this->Html->link($loanGuarantor->loan_application->currency, ['controller' => 'LoanApplications', 'action' => 'view', $loanGuarantor->loan_application->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($loanGuarantor->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('National Id') ?></th>
                    <td><?= h($loanGuarantor->national_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Relationship') ?></th>
                    <td><?= h($loanGuarantor->relationship) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($loanGuarantor->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employer') ?></th>
                    <td><?= h($loanGuarantor->employer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanGuarantor->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanGuarantor->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanGuarantor->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monthly Income') ?></th>
                    <td><?= $loanGuarantor->monthly_income === null ? '' : $this->Number->format($loanGuarantor->monthly_income) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanGuarantor->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanGuarantor->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>