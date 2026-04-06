<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Budget'), ['action' => 'edit', $budget->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Budget'), ['action' => 'delete', $budget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Budgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Budget'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="budgets view content">
            <h3><?= h($budget->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $budget->hasValue('account') ? $this->Html->link($budget->account->name, ['controller' => 'Accounts', 'action' => 'view', $budget->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $budget->hasValue('company') ? $this->Html->link($budget->company->name, ['controller' => 'Companies', 'action' => 'view', $budget->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($budget->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($budget->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($budget->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($budget->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($budget->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($budget->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>