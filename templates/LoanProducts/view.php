<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanProduct $loanProduct
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Product'), ['action' => 'edit', $loanProduct->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Product'), ['action' => 'delete', $loanProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanProduct->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanProducts view content">
            <h3><?= h($loanProduct->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $loanProduct->hasValue('company') ? $this->Html->link($loanProduct->company->name, ['controller' => 'Companies', 'action' => 'view', $loanProduct->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($loanProduct->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($loanProduct->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Method') ?></th>
                    <td><?= h($loanProduct->interest_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Repayment Frequency') ?></th>
                    <td><?= h($loanProduct->repayment_frequency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanProduct->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanProduct->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Rate') ?></th>
                    <td><?= $this->Number->format($loanProduct->interest_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Min Amount') ?></th>
                    <td><?= $this->Number->format($loanProduct->min_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Amount') ?></th>
                    <td><?= $this->Number->format($loanProduct->max_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Term') ?></th>
                    <td><?= $this->Number->format($loanProduct->max_term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Min Term') ?></th>
                    <td><?= $this->Number->format($loanProduct->min_term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grace Period Days') ?></th>
                    <td><?= $this->Number->format($loanProduct->grace_period_days) ?></td>
                </tr>
                <tr>
                    <th><?= __('Penalty Rate') ?></th>
                    <td><?= $this->Number->format($loanProduct->penalty_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanProduct->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanProduct->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Requires Guarantor') ?></th>
                    <td><?= $loanProduct->requires_guarantor ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $loanProduct->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanProduct->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Loan Applications') ?></h4>
                <?php if (!empty($loanProduct->loan_applications)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Client Id') ?></th>
                            <th><?= __('Loan Product Id') ?></th>
                            <th><?= __('Amount Requested') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Term') ?></th>
                            <th><?= __('Purpose') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Submitted At') ?></th>
                            <th><?= __('Decided At') ?></th>
                            <th><?= __('Decided By') ?></th>
                            <th><?= __('Rejection Reason') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($loanProduct->loan_applications as $loanApplication) : ?>
                        <tr>
                            <td><?= h($loanApplication->id) ?></td>
                            <td><?= h($loanApplication->company_id) ?></td>
                            <td><?= h($loanApplication->client_id) ?></td>
                            <td><?= h($loanApplication->loan_product_id) ?></td>
                            <td><?= h($loanApplication->amount_requested) ?></td>
                            <td><?= h($loanApplication->currency) ?></td>
                            <td><?= h($loanApplication->term) ?></td>
                            <td><?= h($loanApplication->purpose) ?></td>
                            <td><?= h($loanApplication->status) ?></td>
                            <td><?= h($loanApplication->submitted_at) ?></td>
                            <td><?= h($loanApplication->decided_at) ?></td>
                            <td><?= h($loanApplication->decided_by) ?></td>
                            <td><?= h($loanApplication->rejection_reason) ?></td>
                            <td><?= h($loanApplication->notes) ?></td>
                            <td><?= h($loanApplication->created) ?></td>
                            <td><?= h($loanApplication->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LoanApplications', 'action' => 'view', $loanApplication->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LoanApplications', 'action' => 'edit', $loanApplication->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LoanApplications', 'action' => 'delete', $loanApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanApplication->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Loans') ?></h4>
                <?php if (!empty($loanProduct->loans)) : ?>
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
                        <?php foreach ($loanProduct->loans as $loan) : ?>
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