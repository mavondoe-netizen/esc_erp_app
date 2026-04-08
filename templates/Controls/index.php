<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Control> $controls
 */
?>
<div class="controls index content">
    <?= $this->Html->link(__('New Control'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Controls') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('risk_id') ?></th>
                    <th><?= $this->Paginator->sort('control_name') ?></th>
                    <th><?= $this->Paginator->sort('control_type') ?></th>
                    <th><?= $this->Paginator->sort('frequency') ?></th>
                    <th><?= $this->Paginator->sort('owner_id') ?></th>
                    <th><?= $this->Paginator->sort('effectiveness_rating') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($controls as $control): ?>
                <tr>
                    <td><?= $this->Number->format($control->id) ?></td>
                    <td><?= $control->hasValue('company') ? $this->Html->link($control->company->name, ['controller' => 'Companies', 'action' => 'view', $control->company->id]) : '' ?></td>
                    <td><?= $control->hasValue('risk') ? $this->Html->link($control->risk->title, ['controller' => 'Risks', 'action' => 'view', $control->risk->id]) : '' ?></td>
                    <td><?= h($control->control_name) ?></td>
                    <td><?= h($control->control_type) ?></td>
                    <td><?= h($control->frequency) ?></td>
                    <td><?= $control->owner_id === null ? '' : $this->Number->format($control->owner_id) ?></td>
                    <td><?= h($control->effectiveness_rating) ?></td>
                    <td><?= h($control->created) ?></td>
                    <td><?= h($control->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $control->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $control->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $control->id], ['confirm' => __('Are you sure you want to delete # {0}?', $control->id)]) ?>
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