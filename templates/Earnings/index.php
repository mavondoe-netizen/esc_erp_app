<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Earning> $earnings
 */
?>
<div class="earnings index content">
    <?= $this->Html->link(__('New Earning'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Earnings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all-rows"></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('taxable') ?></th>
                    <th><?= $this->Paginator->sort('pensionable') ?></th>
                    <th><?= $this->Paginator->sort('nssa_applicable') ?></th>
                    <th><?= $this->Paginator->sort('calculation_type') ?></th>
                    <th><?= __('ZIMRA Mapping') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($earnings as $earning): ?>
                <tr>
                    <td><input type="checkbox" class="row-checkbox" value="<?= $earning->id ?>"></td>
                    <td><?= $this->Number->format($earning->id) ?></td>
                    <td><?= h($earning->name) ?></td>
                    <td><?= $earning->hasValue('account') ? $this->Html->link($earning->account->name, ['controller' => 'Accounts', 'action' => 'view', $earning->account->id]) : '' ?></td>
                    <td><?= h($earning->taxable) ?></td>
                    <td><?= h($earning->pensionable) ?></td>
                    <td><?= h($earning->nssa_applicable) ?></td>
                    <td><?= h($earning->calculation_type) ?></td>
                    <td><span class="badge" style="background-color: #f0f0f0; color: #333; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;"><?= $earning->zimra_mapping ? h($zimraOptions[$earning->zimra_mapping] ?? $earning->zimra_mapping) : '<em style="color: #999;">Not Mapped</em>' ?></span></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $earning->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $earning->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $earning->id], ['confirm' => __('Are you sure you want to delete # {0}?', $earning->id)]) ?>
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