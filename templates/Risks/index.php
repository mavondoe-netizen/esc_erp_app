<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Risk> $risks
 */
?>
<div class="risks index content">
    <?= $this->Html->link(__('New Risk'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Risks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('business_unit_id') ?></th>
                    <th><?= $this->Paginator->sort('owner_id') ?></th>
                    <th><?= $this->Paginator->sort('inherent_risk_score') ?></th>
                    <th><?= $this->Paginator->sort('residual_risk_score') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($risks as $risk): ?>
                <tr>
                    <td><?= $this->Number->format($risk->id) ?></td>
                    <td><?= $risk->hasValue('company') ? $this->Html->link($risk->company->name, ['controller' => 'Companies', 'action' => 'view', $risk->company->id]) : '' ?></td>
                    <td><?= h($risk->title) ?></td>
                    <td><?= h($risk->category) ?></td>
                    <td><?= $risk->business_unit_id === null ? '' : $this->Number->format($risk->business_unit_id) ?></td>
                    <td><?= $risk->owner_id === null ? '' : $this->Number->format($risk->owner_id) ?></td>
                    <td><?= $risk->inherent_risk_score === null ? '' : $this->Number->format($risk->inherent_risk_score) ?></td>
                    <td><?= $risk->residual_risk_score === null ? '' : $this->Number->format($risk->residual_risk_score) ?></td>
                    <td><?= h($risk->status) ?></td>
                    <td><?= h($risk->created) ?></td>
                    <td><?= h($risk->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $risk->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $risk->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $risk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $risk->id)]) ?>
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