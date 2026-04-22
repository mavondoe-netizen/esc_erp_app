<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Building> $buildings
 */
?>
<div class="buildings index content">
    <?= $this->Html->link(__('New Building'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Buildings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= __('Occupancy') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buildings as $building): ?>
                <tr>
                    <td><?= $this->Number->format($building->id) ?></td>
                    <td><?= h($building->name) ?></td>
                    <td><?= h($building->address) ?></td>
                    
                    <td><?= h($building->start_date) ?></td>
                    <td><?= $this->Number->format($building->occupancy_rate, ['precision' => 0]) ?>%</td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $building->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $building->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $building->id], ['confirm' => __('Are you sure you want to delete # {0}?', $building->id)]) ?>
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