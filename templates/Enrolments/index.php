<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Enrolment> $enrolments
 */
?>
<div class="enrolments index content">
    <?= $this->Html->link(__('New Enrolment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Enrolments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id') ?></th>
                    <th><?= $this->Paginator->sort('unit_id') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('rate') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrolments as $enrolment): ?>
                <tr>
                    <td><?= $this->Number->format($enrolment->id) ?></td>
                    <td><?= $this->Number->format($enrolment->tenant_id) ?></td>
                    <td><?= $enrolment->hasValue('unit') ? $this->Html->link($enrolment->unit->name, ['controller' => 'Units', 'action' => 'view', $enrolment->unit->id]) : '' ?></td>
                    <td><?= h($enrolment->start_date) ?></td>
                    <td><?= h($enrolment->end_date) ?></td>
                    <td><?= $this->Number->format($enrolment->rate) ?></td>
                    <td><?= h($enrolment->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $enrolment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $enrolment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $enrolment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrolment->id)]) ?>
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