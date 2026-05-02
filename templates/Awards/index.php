<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Award> $awards
 */
?>
<div class="awards index content">
    <?= $this->Html->link(__('New Award'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Awards') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tender_id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('awarded_amount') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($awards as $award): ?>
                <tr>
                    <td><?= $this->Number->format($award->id) ?></td>
                    <td><?= $award->hasValue('tender') ? $this->Html->link($award->tender->title, ['controller' => 'Tenders', 'action' => 'view', $award->tender->id]) : '' ?></td>
                    <td><?= $award->hasValue('supplier') ? $this->Html->link($award->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $award->supplier->id]) : '' ?></td>
                    <td><?= $this->Number->format($award->awarded_amount) ?></td>
                    <td><?= h($award->status) ?></td>
                    <td><?= $award->hasValue('company') ? $this->Html->link($award->company->name, ['controller' => 'Companies', 'action' => 'view', $award->company->id]) : '' ?></td>
                    <td><?= h($award->created) ?></td>
                    <td><?= h($award->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $award->id]) ?>
                        <?php if ($award->status === 'Draft' || $award->status === 'Pending' || $award->status === 'Rejected'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $award->id]) ?>
                            <?= $this->Form->postLink(__('Submit'), ['action' => 'submit', $award->id], ['confirm' => __('Submit this award for approval?')]) ?>
                        <?php endif; ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $award->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $award->id),
                            ]
                        ) ?>
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