<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Unit> $units
 */
?>
<div class="units index content">
    <?= $this->Html->link(__('New Unit'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Units') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('building_id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($units as $unit): ?>
                <tr>
                    <td><?= $this->Number->format($unit->id) ?></td>
                    <td><?= h($unit->name) ?></td>
                    <td><?= $unit->hasValue('building') ? $this->Html->link($unit->building->name, ['controller' => 'Buildings', 'action' => 'view', $unit->building->id]) : '' ?></td>
                    <td><?= $this->Number->format($unit->area) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $unit->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $unit->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $unit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id)]) ?>
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