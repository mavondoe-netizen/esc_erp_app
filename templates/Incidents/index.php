<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Incident> $incidents
 */
?>
<div class="incidents index content">
    <?= $this->Html->link(__('New Incident'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Incidents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('business_unit_id') ?></th>
                    <th><?= $this->Paginator->sort('reported_by') ?></th>
                    <th><?= $this->Paginator->sort('reported_at') ?></th>
                    <th><?= $this->Paginator->sort('severity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incidents as $incident): ?>
                <tr>
                    <td><?= $this->Number->format($incident->id) ?></td>
                    <td><?= $incident->hasValue('company') ? $this->Html->link($incident->company->name, ['controller' => 'Companies', 'action' => 'view', $incident->company->id]) : '' ?></td>
                    <td><?= h($incident->title) ?></td>
                    <td><?= h($incident->type) ?></td>
                    <td><?= $incident->business_unit_id === null ? '' : $this->Number->format($incident->business_unit_id) ?></td>
                    <td><?= $incident->reported_by === null ? '' : $this->Number->format($incident->reported_by) ?></td>
                    <td><?= h($incident->reported_at) ?></td>
                    <td><?= h($incident->severity) ?></td>
                    <td><?= h($incident->created) ?></td>
                    <td><?= h($incident->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $incident->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incident->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $incident->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incident->id)]) ?>
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