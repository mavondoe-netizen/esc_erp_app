<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LossEvent> $lossEvents
 */
?>
<div class="lossEvents index content">
    <?= $this->Html->link(__('New Loss Event'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loss Events') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('incident_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('recovery_amount') ?></th>
                    <th><?= $this->Paginator->sort('net_loss') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lossEvents as $lossEvent): ?>
                <tr>
                    <td><?= $this->Number->format($lossEvent->id) ?></td>
                    <td><?= $lossEvent->hasValue('company') ? $this->Html->link($lossEvent->company->name, ['controller' => 'Companies', 'action' => 'view', $lossEvent->company->id]) : '' ?></td>
                    <td><?= $lossEvent->hasValue('incident') ? $this->Html->link($lossEvent->incident->title, ['controller' => 'Incidents', 'action' => 'view', $lossEvent->incident->id]) : '' ?></td>
                    <td><?= $this->Number->format($lossEvent->amount) ?></td>
                    <td><?= $lossEvent->recovery_amount === null ? '' : $this->Number->format($lossEvent->recovery_amount) ?></td>
                    <td><?= $lossEvent->net_loss === null ? '' : $this->Number->format($lossEvent->net_loss) ?></td>
                    <td><?= h($lossEvent->created) ?></td>
                    <td><?= h($lossEvent->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $lossEvent->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lossEvent->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lossEvent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lossEvent->id)]) ?>
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