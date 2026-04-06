<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inspection'), ['action' => 'edit', $inspection->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inspection'), ['action' => 'delete', $inspection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inspections'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inspection'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspections view content">
            <h3><?= h($inspection->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($inspection->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $inspection->hasValue('customer') ? $this->Html->link($inspection->customer->name, ['controller' => 'Customers', 'action' => 'view', $inspection->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Inspector') ?></th>
                    <td><?= $inspection->hasValue('inspector') ? $this->Html->link($inspection->inspector->name, ['controller' => 'Inspectors', 'action' => 'view', $inspection->inspector->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inspection->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pobs Insurable') ?></th>
                    <td><?= $this->Number->format($inspection->pobs_insurable) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apwcs Insurable') ?></th>
                    <td><?= $this->Number->format($inspection->apwcs_insurable) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apwcs Penalty') ?></th>
                    <td><?= $this->Number->format($inspection->apwcs_penalty) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($inspection->date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>