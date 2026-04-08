<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanClient $loanClient
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Client'), ['action' => 'edit', $loanClient->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Client'), ['action' => 'delete', $loanClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanClient->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Clients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Client'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanClients view content">
            <h3><?= h($loanClient->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $loanClient->hasValue('company') ? $this->Html->link($loanClient->company->name, ['controller' => 'Companies', 'action' => 'view', $loanClient->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $loanClient->hasValue('employee') ? $this->Html->link($loanClient->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $loanClient->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($loanClient->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('National Id') ?></th>
                    <td><?= h($loanClient->national_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= h($loanClient->gender) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employer Name') ?></th>
                    <td><?= h($loanClient->employer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employment Type') ?></th>
                    <td><?= h($loanClient->employment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Income Currency') ?></th>
                    <td><?= h($loanClient->income_currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Phone') ?></th>
                    <td><?= h($loanClient->contact_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Email') ?></th>
                    <td><?= h($loanClient->contact_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanClient->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanClient->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monthly Income') ?></th>
                    <td><?= $this->Number->format($loanClient->monthly_income) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dob') ?></th>
                    <td><?= h($loanClient->dob) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanClient->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanClient->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanClient->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanClient->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>