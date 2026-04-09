<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Office> $offices
 */
?>
<div class="offices index content">
    <?= $this->Html->link(__('New Office'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Offices') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('location') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offices as $office): ?>
                <tr>
                    <td><?= $this->Number->format($office->id) ?></td>
                    <td><?= $office->hasValue('company') ? $this->Html->link($office->company->name, ['controller' => 'Companies', 'action' => 'view', $office->company->id]) : '' ?></td>
                    <td><?= h($office->name) ?></td>
                    <td><?= h($office->location) ?></td>
                    <td><?= h($office->created) ?></td>
                    <td><?= h($office->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $office->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $office->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $office->id], ['confirm' => __('Are you sure you want to delete # {0}?', $office->id)]) ?>
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