<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Earning $earning
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Earning'), ['action' => 'edit', $earning->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Earning'), ['action' => 'delete', $earning->id], ['confirm' => __('Are you sure you want to delete # {0}?', $earning->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Earnings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Earning'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="earnings view content">
            <h3><?= h($earning->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($earning->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $earning->hasValue('account') ? $this->Html->link($earning->account->name, ['controller' => 'Accounts', 'action' => 'view', $earning->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Calculation Type') ?></th>
                    <td><?= h($earning->calculation_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($earning->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Taxable') ?></th>
                    <td><?= $earning->taxable ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Pensionable') ?></th>
                    <td><?= $earning->pensionable ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Nssa Applicable') ?></th>
                    <td><?= $earning->nssa_applicable ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>