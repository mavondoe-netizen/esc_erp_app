<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Deduction> $deductions
 */
?>
<div class="deductions index content">
    <?= $this->Html->link(__('New Deduction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Deductions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all-rows"></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('statutory') ?></th>
                    <th><?= $this->Paginator->sort('tax_deductible') ?></th>
                    <th><?= $this->Paginator->sort('calculation_type') ?></th>
                    <th><?= __('ZIMRA Mapping') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deductions as $deduction): ?>
                <tr>
                    <td><input type="checkbox" class="row-checkbox" value="<?= $deduction->id ?>"></td>
                    <td><?= $this->Number->format($deduction->id) ?></td>
                    <td><?= h($deduction->name) ?></td>
                    <td><?= h($deduction->statutory) ?></td>
                    <td><?= h($deduction->tax_deductible) ?></td>
                    <td><?= h($deduction->calculation_type) ?></td>
                    <td><span class="badge" style="background-color: #f0f0f0; color: #333; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;"><?= $deduction->zimra_mapping ? h($zimraOptions[$deduction->zimra_mapping] ?? $deduction->zimra_mapping) : '<em style="color: #999;">Not Mapped</em>' ?></span></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $deduction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $deduction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $deduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deduction->id)]) ?>
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