<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Contract> $contracts
 */
?>
<div class="contracts index content">
    <?= $this->Html->link(__('New Contract'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contracts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('award_id') ?></th>
                    <th><?= $this->Paginator->sort('contract_number') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contracts as $contract): ?>
                <tr>
                    <td><?= $this->Number->format($contract->id) ?></td>
                    <td><?= $contract->hasValue('award') ? $this->Html->link($contract->award->id, ['controller' => 'Awards', 'action' => 'view', $contract->award->id]) : '' ?></td>
                    <td><?= h($contract->contract_number) ?></td>
                    <td><?= h($contract->start_date) ?></td>
                    <td><?= h($contract->end_date) ?></td>
                    <td><?= h($contract->status) ?></td>
                    <td><?= $contract->hasValue('company') ? $this->Html->link($contract->company->name, ['controller' => 'Companies', 'action' => 'view', $contract->company->id]) : '' ?></td>
                    <td><?= h($contract->created) ?></td>
                    <td><?= h($contract->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contract->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contract->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $contract->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $contract->id),
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