<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PayPeriod> $payPeriods
 */
?>
<div class="payPeriods index content">
    <div style="float: right; margin-bottom: 10px;">
        <?= $this->Form->postLink(
            __('Close & Rollover To Next Month'),
            ['action' => 'rollover'],
            ['confirm' => __('Are you absolutely sure? This will lock the current payroll cycle and generate the next chronological month.'), 'class' => 'button button-outline', 'style' => 'margin-right: 15px;']
        ) ?>
        <?= $this->Html->link(__('New Pay Period'), ['action' => 'add'], ['class' => 'button']) ?>
    </div>
    <h3><?= __('Pay Periods') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all-rows"></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payPeriods as $payPeriod): ?>
                <tr>
                    <td><input type="checkbox" class="row-checkbox" value="<?= $payPeriod->id ?>"></td>
                    <td><?= $this->Number->format($payPeriod->id) ?></td>
                    <td><?= h($payPeriod->name) ?></td>
                    <td><?= h($payPeriod->start_date) ?></td>
                    <td><?= h($payPeriod->end_date) ?></td>
                    <td><?= h($payPeriod->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $payPeriod->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payPeriod->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payPeriod->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payPeriod->id)]) ?>
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