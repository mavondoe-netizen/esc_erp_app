<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payslip> $payslips
 */
?>
<div class="payslips index content">
    <?= $this->Html->link(__('New Payslip'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Payslips') ?></h3>
    <div class="table-responsive">
        <?php foreach($groupedPayslips as $periodName => $periodPayslips): ?>
        <h4 style="margin-top: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px; color: #444;"><?= h($periodName) ?></h4>
        <div style="overflow-x: auto; max-width: 100%; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <table class="no-dt" style="min-width: 1200px; background: #fff; border-radius: 4px;">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 40px;"><input type="checkbox" class="select-all-period"></th>
                        <th rowspan="2"><?= $this->Paginator->sort('id') ?></th>
                        <th rowspan="2"><?= $this->Paginator->sort('employee_id') ?></th>
                        <th rowspan="2"><?= $this->Paginator->sort('generated_date') ?></th>
                        <th rowspan="2"><?= $this->Paginator->sort('gross_pay') ?></th>
                        
                        <?php if (!empty($dynamicColumns['Earnings'])): ?>
                            <th colspan="<?= count($dynamicColumns['Earnings']) ?>" style="text-align: center; border-bottom: 2px solid #ccc; background-color: #f4fce8;">Earnings</th>
                        <?php endif; ?>
                        
                        <?php if (!empty($dynamicColumns['Deductions'])): ?>
                            <th colspan="<?= count($dynamicColumns['Deductions']) ?>" style="text-align: center; border-bottom: 2px solid #ccc; background-color: #fce8e8;">Deductions</th>
                        <?php endif; ?>
                        
                        <?php if (!empty($dynamicColumns['Taxes'])): ?>
                            <th colspan="<?= count($dynamicColumns['Taxes']) ?>" style="text-align: center; border-bottom: 2px solid #ccc; background-color: #fcf4e8;">Taxes</th>
                        <?php endif; ?>

                        <th rowspan="2"><?= $this->Paginator->sort('deductions', 'Total Deductions') ?></th>
                        <th rowspan="2"><?= $this->Paginator->sort('net_pay') ?></th>
                        <th rowspan="2" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <tr>
                        <?php foreach ($dynamicColumns['Earnings'] as $col): ?>
                            <th style="background-color: #fbfdf7; font-size: 0.9em;"><?= h($col) ?></th>
                        <?php endforeach; ?>
                        
                        <?php foreach ($dynamicColumns['Deductions'] as $col): ?>
                            <th style="background-color: #fdf7f7; font-size: 0.9em;"><?= h($col) ?></th>
                        <?php endforeach; ?>
                        
                        <?php foreach ($dynamicColumns['Taxes'] as $col): ?>
                            <th style="background-color: #fdfbf7; font-size: 0.9em;"><?= h($col) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periodPayslips as $payslip): ?>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox" value="<?= $payslip->id ?>"></td>
                        <td><?= $this->Number->format($payslip->id) ?></td>
                        <td><?= $payslip->hasValue('employee') ? $this->Html->link($payslip->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $payslip->employee->id]) : '' ?></td>
                        <td><?= h($payslip->generated_date) ?></td>
                        <td><strong><?= $this->Number->format($payslip->gross_pay) ?></strong></td>
                        
                        <?php 
                        // Helper to pivot items
                        $pivot = function($payslip, $type, $name) {
                            foreach ($payslip->payslip_items as $item) {
                                if ($item->item_type === $type && $item->name === $name) {
                                    return $item->amount;
                                }
                            }
                            return null;
                        };
                        ?>

                        <?php foreach ($dynamicColumns['Earnings'] as $col): ?>
                            <?php $amt = $pivot($payslip, 'Earning', $col); ?>
                            <td><?= $amt !== null ? $this->Number->format($amt) : '-' ?></td>
                        <?php endforeach; ?>
                        
                        <?php foreach ($dynamicColumns['Deductions'] as $col): ?>
                            <?php $amt = $pivot($payslip, 'Deduction', $col); ?>
                            <td><?= $amt !== null ? $this->Number->format($amt) : '-' ?></td>
                        <?php endforeach; ?>
                        
                        <?php foreach ($dynamicColumns['Taxes'] as $col): ?>
                            <?php $amt = $pivot($payslip, 'Tax', $col); ?>
                            <td><?= $amt !== null ? $this->Number->format($amt) : '-' ?></td>
                        <?php endforeach; ?>

                        <td><strong><?= $payslip->deductions === null ? '' : $this->Number->format($payslip->deductions) ?></strong></td>
                        <td><strong><?= $this->Number->format($payslip->net_pay) ?></strong></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $payslip->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payslip->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endforeach; ?>
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