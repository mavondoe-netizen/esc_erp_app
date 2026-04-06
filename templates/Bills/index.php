<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Bill> $bills
 */
?>
<div class="bills index content">
    <?= $this->Html->link(__('New Bill'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bills') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                <tr>
                    <td><?= $this->Number->format($bill->id) ?></td>
                    <td><?= $bill->hasValue('supplier') ? $this->Html->link($bill->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $bill->supplier->id]) : '' ?></td>
                    <td><?= h($bill->date) ?></td>
                    <td><?= h($bill->description) ?></td>
                    <td><?= h($bill->currency) ?></td>
                    <td><?= $this->Number->format($bill->total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bill->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bill->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bill->id)]) ?>
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