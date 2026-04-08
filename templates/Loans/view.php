<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Loan $loan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan'), ['action' => 'edit', $loan->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan'), ['action' => 'delete', $loan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loan->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loans view content">
            <h3><?= h($loan->interest_method) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $loan->hasValue('company') ? $this->Html->link($loan->company->name, ['controller' => 'Companies', 'action' => 'view', $loan->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Loan Application') ?></th>
                    <td><?= $loan->hasValue('loan_application') ? $this->Html->link($loan->loan_application->currency, ['controller' => 'LoanApplications', 'action' => 'view', $loan->loan_application->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Loan Product') ?></th>
                    <td><?= $loan->hasValue('loan_product') ? $this->Html->link($loan->loan_product->name, ['controller' => 'LoanProducts', 'action' => 'view', $loan->loan_product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Loan Account No') ?></th>
                    <td><?= h($loan->loan_account_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Method') ?></th>
                    <td><?= h($loan->interest_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Repayment Frequency') ?></th>
                    <td><?= h($loan->repayment_frequency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loan->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loan->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loan->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Client Id') ?></th>
                    <td><?= $this->Number->format($loan->client_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Principal') ?></th>
                    <td><?= $this->Number->format($loan->principal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outstanding Balance') ?></th>
                    <td><?= $this->Number->format($loan->outstanding_balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Rate') ?></th>
                    <td><?= $this->Number->format($loan->interest_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Term') ?></th>
                    <td><?= $this->Number->format($loan->term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($loan->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Maturity Date') ?></th>
                    <td><?= h($loan->maturity_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disbursed At') ?></th>
                    <td><?= h($loan->disbursed_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Payment Date') ?></th>
                    <td><?= h($loan->last_payment_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loan->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loan->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loan->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Delinquency Flags') ?></h4>
                <?php if (!empty($loan->delinquency_flags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Days Overdue') ?></th>
                            <th><?= __('Amount Overdue') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Category') ?></th>
                            <th><?= __('Flagged At') ?></th>
                            <th><?= __('Resolved At') ?></th>
                            <th><?= __('Notification Sent') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->delinquency_flags as $delinquencyFlag) : ?>
                        <tr>
                            <td><?= h($delinquencyFlag->id) ?></td>
                            <td><?= h($delinquencyFlag->loan_id) ?></td>
                            <td><?= h($delinquencyFlag->days_overdue) ?></td>
                            <td><?= h($delinquencyFlag->amount_overdue) ?></td>
                            <td><?= h($delinquencyFlag->currency) ?></td>
                            <td><?= h($delinquencyFlag->category) ?></td>
                            <td><?= h($delinquencyFlag->flagged_at) ?></td>
                            <td><?= h($delinquencyFlag->resolved_at) ?></td>
                            <td><?= h($delinquencyFlag->notification_sent) ?></td>
                            <td><?= h($delinquencyFlag->notes) ?></td>
                            <td><?= h($delinquencyFlag->created) ?></td>
                            <td><?= h($delinquencyFlag->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'DelinquencyFlags', 'action' => 'view', $delinquencyFlag->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'DelinquencyFlags', 'action' => 'edit', $delinquencyFlag->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DelinquencyFlags', 'action' => 'delete', $delinquencyFlag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $delinquencyFlag->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Deductions') ?></h4>
                <?php if (!empty($loan->loan_deductions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Monthly Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_deductions as $loanDeduction) : ?>
                        <tr>
                            <td><?= h($loanDeduction->id) ?></td>
                            <td><?= h($loanDeduction->loan_id) ?></td>
                            <td><?= h($loanDeduction->employee_id) ?></td>
                            <td><?= h($loanDeduction->monthly_amount) ?></td>
                            <td><?= h($loanDeduction->currency) ?></td>
                            <td><?= h($loanDeduction->status) ?></td>
                            <td><?= h($loanDeduction->start_date) ?></td>
                            <td><?= h($loanDeduction->notes) ?></td>
                            <td><?= h($loanDeduction->created) ?></td>
                            <td><?= h($loanDeduction->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanDeductions', 'action' => 'view', $loanDeduction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanDeductions', 'action' => 'edit', $loanDeduction->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanDeductions', 'action' => 'delete', $loanDeduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDeduction->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Disbursements') ?></h4>
                <?php if (!empty($loan->loan_disbursements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Method') ?></th>
                            <th><?= __('Bank Reference') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Disbursed By') ?></th>
                            <th><?= __('Disbursed At') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_disbursements as $loanDisbursement) : ?>
                        <tr>
                            <td><?= h($loanDisbursement->id) ?></td>
                            <td><?= h($loanDisbursement->loan_id) ?></td>
                            <td><?= h($loanDisbursement->amount) ?></td>
                            <td><?= h($loanDisbursement->currency) ?></td>
                            <td><?= h($loanDisbursement->method) ?></td>
                            <td><?= h($loanDisbursement->bank_reference) ?></td>
                            <td><?= h($loanDisbursement->account_id) ?></td>
                            <td><?= h($loanDisbursement->disbursed_by) ?></td>
                            <td><?= h($loanDisbursement->disbursed_at) ?></td>
                            <td><?= h($loanDisbursement->notes) ?></td>
                            <td><?= h($loanDisbursement->created) ?></td>
                            <td><?= h($loanDisbursement->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanDisbursements', 'action' => 'view', $loanDisbursement->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanDisbursements', 'action' => 'edit', $loanDisbursement->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanDisbursements', 'action' => 'delete', $loanDisbursement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDisbursement->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Repayments') ?></h4>
                <?php if (!empty($loan->loan_repayments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Client Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Source') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Penalty Paid') ?></th>
                            <th><?= __('Interest Paid') ?></th>
                            <th><?= __('Principal Paid') ?></th>
                            <th><?= __('Reference') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Processed By') ?></th>
                            <th><?= __('Allocation Json') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_repayments as $loanRepayment) : ?>
                        <tr>
                            <td><?= h($loanRepayment->id) ?></td>
                            <td><?= h($loanRepayment->loan_id) ?></td>
                            <td><?= h($loanRepayment->client_id) ?></td>
                            <td><?= h($loanRepayment->amount) ?></td>
                            <td><?= h($loanRepayment->currency) ?></td>
                            <td><?= h($loanRepayment->source) ?></td>
                            <td><?= h($loanRepayment->payment_date) ?></td>
                            <td><?= h($loanRepayment->penalty_paid) ?></td>
                            <td><?= h($loanRepayment->interest_paid) ?></td>
                            <td><?= h($loanRepayment->principal_paid) ?></td>
                            <td><?= h($loanRepayment->reference) ?></td>
                            <td><?= h($loanRepayment->account_id) ?></td>
                            <td><?= h($loanRepayment->processed_by) ?></td>
                            <td><?= h($loanRepayment->allocation_json) ?></td>
                            <td><?= h($loanRepayment->notes) ?></td>
                            <td><?= h($loanRepayment->created) ?></td>
                            <td><?= h($loanRepayment->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanRepayments', 'action' => 'view', $loanRepayment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanRepayments', 'action' => 'edit', $loanRepayment->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanRepayments', 'action' => 'delete', $loanRepayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRepayment->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Restructures') ?></h4>
                <?php if (!empty($loan->loan_restructures)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Old Term') ?></th>
                            <th><?= __('New Term') ?></th>
                            <th><?= __('Old Rate') ?></th>
                            <th><?= __('New Rate') ?></th>
                            <th><?= __('Outstanding At Restructure') ?></th>
                            <th><?= __('Reason') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Approved At') ?></th>
                            <th><?= __('Effective Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_restructures as $loanRestructure) : ?>
                        <tr>
                            <td><?= h($loanRestructure->id) ?></td>
                            <td><?= h($loanRestructure->loan_id) ?></td>
                            <td><?= h($loanRestructure->old_term) ?></td>
                            <td><?= h($loanRestructure->new_term) ?></td>
                            <td><?= h($loanRestructure->old_rate) ?></td>
                            <td><?= h($loanRestructure->new_rate) ?></td>
                            <td><?= h($loanRestructure->outstanding_at_restructure) ?></td>
                            <td><?= h($loanRestructure->reason) ?></td>
                            <td><?= h($loanRestructure->status) ?></td>
                            <td><?= h($loanRestructure->approved_by) ?></td>
                            <td><?= h($loanRestructure->approved_at) ?></td>
                            <td><?= h($loanRestructure->effective_date) ?></td>
                            <td><?= h($loanRestructure->created) ?></td>
                            <td><?= h($loanRestructure->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanRestructures', 'action' => 'view', $loanRestructure->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanRestructures', 'action' => 'edit', $loanRestructure->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanRestructures', 'action' => 'delete', $loanRestructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRestructure->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Schedules') ?></h4>
                <?php if (!empty($loan->loan_schedules)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Period Number') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Principal Due') ?></th>
                            <th><?= __('Interest Due') ?></th>
                            <th><?= __('Penalty Due') ?></th>
                            <th><?= __('Total Due') ?></th>
                            <th><?= __('Amount Paid') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_schedules as $loanSchedule) : ?>
                        <tr>
                            <td><?= h($loanSchedule->id) ?></td>
                            <td><?= h($loanSchedule->loan_id) ?></td>
                            <td><?= h($loanSchedule->period_number) ?></td>
                            <td><?= h($loanSchedule->due_date) ?></td>
                            <td><?= h($loanSchedule->principal_due) ?></td>
                            <td><?= h($loanSchedule->interest_due) ?></td>
                            <td><?= h($loanSchedule->penalty_due) ?></td>
                            <td><?= h($loanSchedule->total_due) ?></td>
                            <td><?= h($loanSchedule->amount_paid) ?></td>
                            <td><?= h($loanSchedule->balance) ?></td>
                            <td><?= h($loanSchedule->currency) ?></td>
                            <td><?= h($loanSchedule->status) ?></td>
                            <td><?= h($loanSchedule->created) ?></td>
                            <td><?= h($loanSchedule->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanSchedules', 'action' => 'view', $loanSchedule->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanSchedules', 'action' => 'edit', $loanSchedule->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanSchedules', 'action' => 'delete', $loanSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanSchedule->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Writeoffs') ?></h4>
                <?php if (!empty($loan->loan_writeoffs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Outstanding At Writeoff') ?></th>
                            <th><?= __('Reason') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Approved At') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loan->loan_writeoffs as $loanWriteoff) : ?>
                        <tr>
                            <td><?= h($loanWriteoff->id) ?></td>
                            <td><?= h($loanWriteoff->loan_id) ?></td>
                            <td><?= h($loanWriteoff->amount) ?></td>
                            <td><?= h($loanWriteoff->currency) ?></td>
                            <td><?= h($loanWriteoff->outstanding_at_writeoff) ?></td>
                            <td><?= h($loanWriteoff->reason) ?></td>
                            <td><?= h($loanWriteoff->status) ?></td>
                            <td><?= h($loanWriteoff->approved_by) ?></td>
                            <td><?= h($loanWriteoff->approved_at) ?></td>
                            <td><?= h($loanWriteoff->account_id) ?></td>
                            <td><?= h($loanWriteoff->created) ?></td>
                            <td><?= h($loanWriteoff->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanWriteoffs', 'action' => 'view', $loanWriteoff->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanWriteoffs', 'action' => 'edit', $loanWriteoff->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanWriteoffs', 'action' => 'delete', $loanWriteoff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanWriteoff->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>