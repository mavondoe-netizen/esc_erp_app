<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanRestructure $loanRestructure
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Restructure'), ['action' => 'edit', $loanRestructure->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Restructure'), ['action' => 'delete', $loanRestructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRestructure->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Restructures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Restructure'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanRestructures view content">
            <h3><?= h($loanRestructure->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanRestructure->hasValue('loan') ? $this->Html->link($loanRestructure->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanRestructure->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanRestructure->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanRestructure->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Old Term') ?></th>
                    <td><?= $loanRestructure->old_term === null ? '' : $this->Number->format($loanRestructure->old_term) ?></td>
                </tr>
                <tr>
                    <th><?= __('New Term') ?></th>
                    <td><?= $this->Number->format($loanRestructure->new_term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Old Rate') ?></th>
                    <td><?= $loanRestructure->old_rate === null ? '' : $this->Number->format($loanRestructure->old_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('New Rate') ?></th>
                    <td><?= $loanRestructure->new_rate === null ? '' : $this->Number->format($loanRestructure->new_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outstanding At Restructure') ?></th>
                    <td><?= $loanRestructure->outstanding_at_restructure === null ? '' : $this->Number->format($loanRestructure->outstanding_at_restructure) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $loanRestructure->approved_by === null ? '' : $this->Number->format($loanRestructure->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved At') ?></th>
                    <td><?= h($loanRestructure->approved_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Effective Date') ?></th>
                    <td><?= h($loanRestructure->effective_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanRestructure->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanRestructure->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Reason') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanRestructure->reason)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>