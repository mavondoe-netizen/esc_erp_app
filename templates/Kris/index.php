<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Kri> $kris
 */
?>
<div class="kris index content">
    <?= $this->Html->link(__('New Kri'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Kris') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('risk_id') ?></th>
                    <th><?= $this->Paginator->sort('metric') ?></th>
                    <th><?= $this->Paginator->sort('threshold') ?></th>
                    <th><?= $this->Paginator->sort('current_value') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kris as $kri): ?>
                <tr>
                    <td><?= $this->Number->format($kri->id) ?></td>
                    <td><?= $kri->hasValue('company') ? $this->Html->link($kri->company->name, ['controller' => 'Companies', 'action' => 'view', $kri->company->id]) : '' ?></td>
                    <td><?= $kri->hasValue('risk') ? $this->Html->link($kri->risk->title, ['controller' => 'Risks', 'action' => 'view', $kri->risk->id]) : '' ?></td>
                    <td><?= h($kri->metric) ?></td>
                    <td><?= $this->Number->format($kri->threshold) ?></td>
                    <td><?= $this->Number->format($kri->current_value) ?></td>
                    <td><?= h($kri->status) ?></td>
                    <td><?= h($kri->created) ?></td>
                    <td><?= h($kri->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $kri->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $kri->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $kri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kri->id)]) ?>
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