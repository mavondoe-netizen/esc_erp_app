<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LevyItem $levyItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Levy Item'), ['action' => 'edit', $levyItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Levy Item'), ['action' => 'delete', $levyItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $levyItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Levy Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Levy Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?php if ($levyItem->hasValue('levy')): ?>
                <?= $this->Html->link(__('Back to Levy'), ['controller' => 'Levies', 'action' => 'view', $levyItem->levy_id], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="levyItems view content">
            <h3><?= h($levyItem->description ?? 'Levy Item #' . $levyItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Levy') ?></th>
                    <td><?= $levyItem->hasValue('levy') ? $this->Html->link($levyItem->levy->levy_type, ['controller' => 'Levies', 'action' => 'view', $levyItem->levy->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $levyItem->hasValue('account') ? $this->Html->link($levyItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $levyItem->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $levyItem->hasValue('product') ? $this->Html->link($levyItem->product->name, ['controller' => 'Products', 'action' => 'view', $levyItem->product->id]) : '–' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($levyItem->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($levyItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($levyItem->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total') ?></th>
                    <td><?= $this->Number->format($levyItem->line_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('VAT Rate') ?></th>
                    <td><?= h($levyItem->vat_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('VAT Amount') ?></th>
                    <td><?= h($levyItem->vat_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('VAT Type') ?></th>
                    <td><?= h($levyItem->vat_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('HS Code') ?></th>
                    <td><?= h($levyItem->hs_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($levyItem->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
