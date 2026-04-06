<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deduction $deduction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Deduction'), ['action' => 'edit', $deduction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Deduction'), ['action' => 'delete', $deduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deduction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Deductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Deduction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deductions view content">
            <h3><?= h($deduction->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($deduction->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Calculation Type') ?></th>
                    <td><?= h($deduction->calculation_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($deduction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Statutory') ?></th>
                    <td><?= $deduction->statutory ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax Deductible') ?></th>
                    <td><?= $deduction->tax_deductible ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>