<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Estimate> $estimates
 */
?>
<div class="estimates index content">
    <?= $this->Html->link(__('New Estimate'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Estimates') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('expiry_date') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estimates as $estimate): ?>
                <tr>
                    <td><?= $this->Number->format($estimate->id) ?></td>
                    <td><?= $estimate->hasValue('company') ? $this->Html->link($estimate->company->name, ['controller' => 'Companies', 'action' => 'view', $estimate->company->id]) : '' ?></td>
                    <td><?= $estimate->hasValue('customer') ? $this->Html->link($estimate->customer->name, ['controller' => 'Customers', 'action' => 'view', $estimate->customer->id]) : '' ?></td>
                    <td><?= h($estimate->date) ?></td>
                    <td><?= h($estimate->expiry_date) ?></td>
                    <td><?= h($estimate->description) ?></td>
                    <td><?= $estimate->total === null ? '' : $this->Number->format($estimate->total) ?></td>
                    <td><?= h($estimate->status) ?></td>
                    <td><?= h($estimate->created) ?></td>
                    <td><?= h($estimate->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $estimate->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estimate->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estimate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estimate->id)]) ?>
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