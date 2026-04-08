<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ControlTest> $controlTests
 */
?>
<div class="controlTests index content">
    <?= $this->Html->link(__('New Control Test'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Control Tests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('control_id') ?></th>
                    <th><?= $this->Paginator->sort('tested_by') ?></th>
                    <th><?= $this->Paginator->sort('tested_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($controlTests as $controlTest): ?>
                <tr>
                    <td><?= $this->Number->format($controlTest->id) ?></td>
                    <td><?= $controlTest->hasValue('company') ? $this->Html->link($controlTest->company->name, ['controller' => 'Companies', 'action' => 'view', $controlTest->company->id]) : '' ?></td>
                    <td><?= $controlTest->hasValue('control') ? $this->Html->link($controlTest->control->control_name, ['controller' => 'Controls', 'action' => 'view', $controlTest->control->id]) : '' ?></td>
                    <td><?= $controlTest->tested_by === null ? '' : $this->Number->format($controlTest->tested_by) ?></td>
                    <td><?= h($controlTest->tested_at) ?></td>
                    <td><?= h($controlTest->created) ?></td>
                    <td><?= h($controlTest->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $controlTest->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $controlTest->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $controlTest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlTest->id)]) ?>
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