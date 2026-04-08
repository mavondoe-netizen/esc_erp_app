<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanApplication $loanApplication
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Application'), ['action' => 'edit', $loanApplication->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Application'), ['action' => 'delete', $loanApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanApplication->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Application'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanApplications view content">
            <h3><?= h($loanApplication->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $loanApplication->hasValue('company') ? $this->Html->link($loanApplication->company->name, ['controller' => 'Companies', 'action' => 'view', $loanApplication->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Loan Product') ?></th>
                    <td><?= $loanApplication->hasValue('loan_product') ? $this->Html->link($loanApplication->loan_product->name, ['controller' => 'LoanProducts', 'action' => 'view', $loanApplication->loan_product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanApplication->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Purpose') ?></th>
                    <td><?= h($loanApplication->purpose) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanApplication->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanApplication->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Client Id') ?></th>
                    <td><?= $this->Number->format($loanApplication->client_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount Requested') ?></th>
                    <td><?= $this->Number->format($loanApplication->amount_requested) ?></td>
                </tr>
                <tr>
                    <th><?= __('Term') ?></th>
                    <td><?= $this->Number->format($loanApplication->term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Decided By') ?></th>
                    <td><?= $loanApplication->decided_by === null ? '' : $this->Number->format($loanApplication->decided_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Submitted At') ?></th>
                    <td><?= h($loanApplication->submitted_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Decided At') ?></th>
                    <td><?= h($loanApplication->decided_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanApplication->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanApplication->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Rejection Reason') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanApplication->rejection_reason)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanApplication->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Guarantors') ?></h4>
                <?php if (!empty($loanApplication->loan_guarantors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Loan Application Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('National Id') ?></th>
                            <th><?= __('Relationship') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Employer') ?></th>
                            <th><?= __('Monthly Income') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loanApplication->loan_guarantors as $loanGuarantor) : ?>
                        <tr>
                            <td><?= h($loanGuarantor->id) ?></td>
                            <td><?= h($loanGuarantor->loan_application_id) ?></td>
                            <td><?= h($loanGuarantor->name) ?></td>
                            <td><?= h($loanGuarantor->national_id) ?></td>
                            <td><?= h($loanGuarantor->relationship) ?></td>
                            <td><?= h($loanGuarantor->phone) ?></td>
                            <td><?= h($loanGuarantor->employer) ?></td>
                            <td><?= h($loanGuarantor->monthly_income) ?></td>
                            <td><?= h($loanGuarantor->currency) ?></td>
                            <td><?= h($loanGuarantor->status) ?></td>
                            <td><?= h($loanGuarantor->created) ?></td>
                            <td><?= h($loanGuarantor->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanGuarantors', 'action' => 'view', $loanGuarantor->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanGuarantors', 'action' => 'edit', $loanGuarantor->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanGuarantors', 'action' => 'delete', $loanGuarantor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanGuarantor->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loans') ?></h4>
                <?php if (!empty($loanApplication->loans)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Client Id') ?></th>
                            <th><?= __('Loan Application Id') ?></th>
                            <th><?= __('Loan Product Id') ?></th>
                            <th><?= __('Loan Account No') ?></th>
                            <th><?= __('Principal') ?></th>
                            <th><?= __('Outstanding Balance') ?></th>
                            <th><?= __('Interest Rate') ?></th>
                            <th><?= __('Interest Method') ?></th>
                            <th><?= __('Repayment Frequency') ?></th>
                            <th><?= __('Term') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('Maturity Date') ?></th>
                            <th><?= __('Disbursed At') ?></th>
                            <th><?= __('Last Payment Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loanApplication->loans as $loan) : ?>
                        <tr>
                            <td><?= h($loan->id) ?></td>
                            <td><?= h($loan->company_id) ?></td>
                            <td><?= h($loan->client_id) ?></td>
                            <td><?= h($loan->loan_application_id) ?></td>
                            <td><?= h($loan->loan_product_id) ?></td>
                            <td><?= h($loan->loan_account_no) ?></td>
                            <td><?= h($loan->principal) ?></td>
                            <td><?= h($loan->outstanding_balance) ?></td>
                            <td><?= h($loan->interest_rate) ?></td>
                            <td><?= h($loan->interest_method) ?></td>
                            <td><?= h($loan->repayment_frequency) ?></td>
                            <td><?= h($loan->term) ?></td>
                            <td><?= h($loan->currency) ?></td>
                            <td><?= h($loan->start_date) ?></td>
                            <td><?= h($loan->maturity_date) ?></td>
                            <td><?= h($loan->disbursed_at) ?></td>
                            <td><?= h($loan->last_payment_date) ?></td>
                            <td><?= h($loan->status) ?></td>
                            <td><?= h($loan->notes) ?></td>
                            <td><?= h($loan->created) ?></td>
                            <td><?= h($loan->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Loans', 'action' => 'view', $loan->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Loans', 'action' => 'edit', $loan->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Loans', 'action' => 'delete', $loan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loan->id)]) ?>
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