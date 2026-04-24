<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LevyItem> $levyItems
 */
?>
<div class="levyItems index content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h3><?= __('Levy Items') ?></h3>
        <?= $this->Html->link(__('+ Add Levy Item'), ['action' => 'add'], ['class' => 'button']) ?>
    </div>
    <div class="table-responsive">
        <table id="levyItemsTable">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('levy_id', 'Levy') ?></th>
                    <th><?= $this->Paginator->sort('account_id', 'Account') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price', 'Unit Price') ?></th>
                    <th><?= $this->Paginator->sort('line_total', 'Line Total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($levyItems as $levyItem): ?>
                <tr>
                    <td><?= $levyItem->hasValue('levy') ? $this->Html->link($levyItem->levy->levy_type, ['controller' => 'Levies', 'action' => 'view', $levyItem->levy->id]) : '–' ?></td>
                    <td><?= $levyItem->hasValue('account') ? $this->Html->link($levyItem->account->name, ['controller' => 'Accounts', 'action' => 'view', $levyItem->account->id]) : '–' ?></td>
                    <td><?= h($levyItem->description) ?></td>
                    <td><?= $this->Number->format($levyItem->quantity) ?></td>
                    <td><?= $this->Number->format($levyItem->unit_price) ?></td>
                    <td><?= $this->Number->format($levyItem->line_total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $levyItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $levyItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $levyItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $levyItem->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
