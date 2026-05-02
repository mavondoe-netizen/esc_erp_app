<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Tender> $tenders
 */
?>
<div class="tenders index content">
    <?= $this->Html->link(__('New Tender'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tenders') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('procurement_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('closing_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenders as $tender): ?>
                <tr>
                    <td><?= $this->Number->format($tender->id) ?></td>
                    <td><?= $tender->hasValue('procurement') ? $this->Html->link($tender->procurement->procurement_method, ['controller' => 'Procurements', 'action' => 'view', $tender->procurement->id]) : '' ?></td>
                    <td><?= h($tender->title) ?></td>
                    <td><?= h($tender->closing_date) ?></td>
                    <td><?= h($tender->status) ?></td>
                    <td><?= $tender->hasValue('company') ? $this->Html->link($tender->company->name, ['controller' => 'Companies', 'action' => 'view', $tender->company->id]) : '' ?></td>
                    <td><?= h($tender->created) ?></td>
                    <td><?= h($tender->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tender->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tender->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $tender->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $tender->id),
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