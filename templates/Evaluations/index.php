<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Evaluation> $evaluations
 */
?>
<div class="evaluations index content">
    <?= $this->Html->link(__('New Evaluation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Evaluations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tender_id') ?></th>
                    <th><?= $this->Paginator->sort('evaluator_id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('technical_score') ?></th>
                    <th><?= $this->Paginator->sort('financial_score') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluations as $evaluation): ?>
                <tr>
                    <td><?= $this->Number->format($evaluation->id) ?></td>
                    <td><?= $evaluation->hasValue('tender') ? $this->Html->link($evaluation->tender->title, ['controller' => 'Tenders', 'action' => 'view', $evaluation->tender->id]) : '' ?></td>
                    <td><?= $evaluation->hasValue('user') ? $this->Html->link($evaluation->user->role_id, ['controller' => 'Users', 'action' => 'view', $evaluation->user->id]) : '' ?></td>
                    <td><?= $evaluation->hasValue('evaluator') ? $this->Html->link($evaluation->evaluator->role_id, ['controller' => 'Users', 'action' => 'view', $evaluation->evaluator->id]) : '' ?></td>
                    <td><?= $evaluation->hasValue('supplier') ? $this->Html->link($evaluation->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $evaluation->supplier->id]) : '' ?></td>
                    <td><?= $this->Number->format($evaluation->technical_score) ?></td>
                    <td><?= $this->Number->format($evaluation->financial_score) ?></td>
                    <td><?= $evaluation->hasValue('company') ? $this->Html->link($evaluation->company->name, ['controller' => 'Companies', 'action' => 'view', $evaluation->company->id]) : '' ?></td>
                    <td><?= h($evaluation->created) ?></td>
                    <td><?= h($evaluation->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $evaluation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $evaluation->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $evaluation->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $evaluation->id),
                            ]
                        ) ?>
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