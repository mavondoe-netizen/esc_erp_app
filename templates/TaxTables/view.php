<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TaxTable $taxTable
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tax Table'), ['action' => 'edit', $taxTable->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tax Table'), ['action' => 'delete', $taxTable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taxTable->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tax Tables'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tax Table'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="taxTables view content">
            <h3><?= h($taxTable->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($taxTable->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($taxTable->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lower Limit') ?></th>
                    <td><?= $this->Number->format($taxTable->lower_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Upper Limit') ?></th>
                    <td><?= $this->Number->format($taxTable->upper_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rate') ?></th>
                    <td><?= $this->Number->format($taxTable->rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deduction') ?></th>
                    <td><?= $this->Number->format($taxTable->deduction) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax Year') ?></th>
                    <td><?= h($taxTable->tax_year) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>