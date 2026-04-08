<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Repair> $repairs
 */
$statusColors = ['Reported' => 'orange', 'In Progress' => 'blue', 'Completed' => 'green', 'Cancelled' => 'gray'];
?>
<div class="repairs index content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h3><?= __('Repairs & Maintenance') ?></h3>
        <?= $this->Html->link(__('+ Log Repair'), ['action' => 'add'], ['class' => 'button']) ?>
    </div>
    <div class="table-responsive">
        <table id="repairsTable">
            <thead>
                <tr>
                    <th><?= __('Title') ?></th>
                    <th><?= __('Building') ?></th>
                    <th><?= __('Unit') ?></th>
                    <th><?= __('Category') ?></th>
                    <th><?= __('Reported') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Cost') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repairs as $r): ?>
                <tr>
                    <td><strong><?= h($r->title) ?></strong></td>
                    <td><?= $r->hasValue('building') ? h($r->building->name) : '–' ?></td>
                    <td><?= $r->hasValue('unit') ? h($r->unit->name) : '–' ?></td>
                    <td><?= h($r->category) ?></td>
                    <td><?= h($r->reported_date) ?></td>
                    <td>
                        <span style="color:<?= $statusColors[$r->status] ?? 'black' ?>;font-weight:bold">
                            <?= h($r->status) ?>
                        </span>
                    </td>
                    <td><?= $r->cost ? h($r->currency) . ' ' . number_format((float)$r->cost, 2) : '–' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $r->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $r->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $r->id], ['confirm' => 'Delete this repair?']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>