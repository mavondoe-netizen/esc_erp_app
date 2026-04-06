<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TaxTable> $taxTables
 */
?>
<div class="taxTables index content">
    <?= $this->Html->link(__('New Tax Table'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tax Tables') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('lower_limit') ?></th>
                    <th><?= $this->Paginator->sort('upper_limit') ?></th>
                    <th><?= $this->Paginator->sort('rate') ?></th>
                    <th><?= $this->Paginator->sort('deduction') ?></th>
                    <th><?= $this->Paginator->sort('tax_year') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taxTables as $taxTable): ?>
                <tr>
                    <td><?= $this->Number->format($taxTable->id) ?></td>
                    <td><?= h($taxTable->currency) ?></td>
                    <td><?= $this->Number->format($taxTable->lower_limit) ?></td>
                    <td><?= $this->Number->format($taxTable->upper_limit) ?></td>
                    <td><?= $this->Number->format($taxTable->rate) ?></td>
                    <td><?= $this->Number->format($taxTable->deduction) ?></td>
                    <td><?= h($taxTable->tax_year) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $taxTable->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $taxTable->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $taxTable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taxTable->id)]) ?>
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