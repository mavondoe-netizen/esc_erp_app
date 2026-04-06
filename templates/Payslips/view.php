<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 */

$usdEarnings = [];
$zwgEarnings = [];
$usdDeductions = [];
$zwgDeductions = [];
$usdTaxes = [];
$zwgTaxes = [];

if (!empty($payslip->payslip_items)) {
    foreach ($payslip->payslip_items as $item) {
        $currency = $item->currency === 'USD' ? 'USD' : 'ZWG';
        if ($item->item_type === 'Earning') {
            if ($currency === 'USD') $usdEarnings[] = $item; else $zwgEarnings[] = $item;
        } elseif ($item->item_type === 'Deduction') {
            if ($currency === 'USD') $usdDeductions[] = $item; else $zwgDeductions[] = $item;
        } elseif ($item->item_type === 'Tax') {
            if ($currency === 'USD') $usdTaxes[] = $item; else $zwgTaxes[] = $item;
        }
    }
}
?>
<style>
@media print {
    body * { visibility: hidden; }
    .payslips.view.content, .payslips.view.content * { visibility: visible; }
    .payslips.view.content { position: absolute; left: 0; top: 0; width: 100%; padding: 0; box-shadow: none; border: none; margin: 0; }
    .btn-print, .print-hidden { display: none !important; }
    @page { margin: 1.5cm; size: A4 portrait; }
}
.btn-print {
    background-color: #2e6c80;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    margin-top: -15px;
    margin-bottom: 20px;
    cursor: pointer;
    border: none;
    font-weight: bold;
    float: right;
}
.btn-print:hover { background-color: #1f4f60; }
</style>
<div class="row">
    <aside class="column print-hidden" style="flex: 0 0 20%; max-width: 20%;">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Payslip'), ['action' => 'edit', $payslip->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Payslip'), ['action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Payslips'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payslip'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payslips view content" style="max-width: 900px; margin: 0 auto; background: white; padding: 20px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
            <button onclick="window.print()" class="btn-print print-hidden">🖨️ Print Payslip</button>
            <div style="clear: both;"></div>

            <div class="payslip-container">
                <!-- Header -->
                <div style="text-align: center; border-bottom: 3px solid #2e6c80; padding-bottom: 10px; margin-bottom: 20px;">
                    <h2 style="margin: 0; color: #2e6c80; font-weight: bold; font-size: 24px;">ESCerp App</h2>
                    <h4 style="margin: 5px 0 0 0; color: #555; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Official Payslip</h4>
                </div>

                <!-- Meta Info box -->
                <div style="background-color: #f9f9fa; border: 1px solid #e0e0e0; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                    <div class="row" style="margin: 0; padding: 0;">
                        <div class="column column-50" style="padding: 0;">
                            <table class="no-dt payslip-table" style="width: 100%; border: none; margin: 0; font-size: 14px;">
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; width: 35%; border: none; color: #555;">Employee Name:</th>
                                    <td style="padding: 4px 0; font-weight: bold; border: none; color: #333;"><?= $payslip->hasValue('employee') ? h($payslip->employee->first_name . ' ' . $payslip->employee->last_name) : '' ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; border: none; color: #555;">Employee Code:</th>
                                    <td style="padding: 4px 0; border: none; color: #333;"><?= $payslip->hasValue('employee') ? h($payslip->employee->employee_code) : '' ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; border: none; color: #555;">Pay Period:</th>
                                    <td style="padding: 4px 0; border: none; color: #333;"><?= $payslip->hasValue('pay_period') ? h($payslip->pay_period->name) : '' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="column column-50" style="padding: 0;">
                            <table class="no-dt payslip-table" style="width: 100%; border: none; margin: 0; font-size: 14px;">
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; width: 45%; border: none; color: #555;">Payslip Number:</th>
                                    <td style="padding: 4px 0; border: none; color: #333; text-align: right; font-weight: bold;">#<?= h($payslip->id) ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; border: none; color: #555;">Date Generated:</th>
                                    <td style="padding: 4px 0; border: none; color: #333; text-align: right;"><?= h($payslip->generated_date) ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; padding: 4px 0; border: none; color: #555;">Exchange Rate:</th>
                                    <td style="padding: 4px 0; border: none; color: #333; text-align: right;">1 USD = <?= $this->Number->format($payslip->exchange_rate ?? 1.0, ['places' => 4]) ?> ZWG</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tiled Layout for Earnings and Deductions -->
                <div class="row" style="margin-bottom: 20px; align-items: stretch;">
                    <!-- EARNINGS COLUMN -->
                    <div class="column column-50" style="padding-right: 15px;">
                        <div style="border: 1px solid #ccc; border-radius: 6px; overflow: hidden; height: 100%;">
                            <h4 style="background-color: #2e6c80; color: white; margin: 0; padding: 8px 15px; font-size: 14px; font-weight: bold; letter-spacing: 1px;">EARNINGS</h4>
                            <div style="padding: 15px; min-height: 250px;">
                                
                                <table class="no-dt payslip-table" style="width: 100%; font-size: 13px; margin: 0; border-collapse: collapse;">
                                    <?php if (!empty($usdEarnings)): ?>
                                        <tr><td colspan="2" style="font-weight: bold; color: #2e6c80; padding: 5px 0 2px 0; border-bottom: 1px solid #2e6c80; border-top: none;">USD Earnings</td></tr>
                                        <?php foreach ($usdEarnings as $earning): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($earning->name) ?></td>
                                            <td style="text-align: right; padding: 4px 0; border: none;"><?= $this->Number->currency($earning->amount, 'USD') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td style="padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;">Subtotal USD</td>
                                            <td style="text-align: right; padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;"><?= $this->Number->currency($payslip->usd_gross, 'USD') ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($zwgEarnings)): ?>
                                        <tr><td colspan="2" style="font-weight: bold; color: #9b4dca; padding: 10px 0 2px 0; border-bottom: 1px solid #9b4dca; border-top: none;">ZWG Earnings</td></tr>
                                        <?php foreach ($zwgEarnings as $earning): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($earning->name) ?></td>
                                            <td style="text-align: right; padding: 4px 0; border: none;">ZWG <?= $this->Number->format($earning->amount, ['places' => 2]) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td style="padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;">Subtotal ZWG</td>
                                            <td style="text-align: right; padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;">ZWG <?= $this->Number->format($payslip->zwg_gross, ['places' => 2]) ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    
                                    <?php if(empty($usdEarnings) && empty($zwgEarnings)): ?>
                                        <tr><td colspan="2" style="text-align: center; color: #888; font-style: italic; padding: 20px 0; border: none;">No earnings recorded</td></tr>
                                    <?php endif; ?>
                                </table>

                            </div>
                            <div style="background-color: #f1f8fa; padding: 10px 15px; border-top: 2px solid #ccc; border-bottom: none;">
                                <table class="no-dt payslip-table" style="width: 100%; margin: 0; font-size: 14px;">
                                    <tr>
                                        <td style="font-weight: bold; color: #333; border: none; padding: 0;">Gross Earnings (USD eq.)</td>
                                        <td style="text-align: right; font-weight: bold; color: #333; border: none; padding: 0;"><?= $this->Number->currency($payslip->gross_pay, 'USD') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- DEDUCTIONS COLUMN -->
                    <div class="column column-50" style="padding-left: 15px;">
                        <div style="border: 1px solid #ccc; border-radius: 6px; overflow: hidden; height: 100%;">
                            <h4 style="background-color: #900000; color: white; margin: 0; padding: 8px 15px; font-size: 14px; font-weight: bold; letter-spacing: 1px;">DEDUCTIONS & TAXES</h4>
                            <div style="padding: 15px; min-height: 250px;">
                                
                                <table class="no-dt payslip-table" style="width: 100%; font-size: 13px; margin: 0; border-collapse: collapse;">
                                    <?php if (!empty($usdDeductions) || !empty($usdTaxes)): ?>
                                        <tr><td colspan="2" style="font-weight: bold; color: #900000; padding: 5px 0 2px 0; border-bottom: 1px solid #900000; border-top: none;">USD Deductions & Taxes</td></tr>
                                        <?php foreach ($usdDeductions as $deduc): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($deduc->name) ?></td>
                                            <td style="text-align: right; padding: 4px 0; color: #900000; border: none;">-<?= $this->Number->currency($deduc->amount, 'USD') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php foreach ($usdTaxes as $tax): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($tax->name) ?> (Tax)</td>
                                            <td style="text-align: right; padding: 4px 0; color: #900000; border: none;">-<?= $this->Number->currency($tax->amount, 'USD') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td style="padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;">Subtotal USD</td>
                                            <td style="text-align: right; padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none; color: #900000;">-<?= $this->Number->currency($payslip->usd_deductions, 'USD') ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if (!empty($zwgDeductions) || !empty($zwgTaxes)): ?>
                                        <tr><td colspan="2" style="font-weight: bold; color: #9b4dca; padding: 10px 0 2px 0; border-bottom: 1px solid #9b4dca; border-top: none;">ZWG Deductions & Taxes</td></tr>
                                        <?php foreach ($zwgDeductions as $deduc): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($deduc->name) ?></td>
                                            <td style="text-align: right; padding: 4px 0; color: #900000; border: none;">-ZWG <?= $this->Number->format($deduc->amount, ['places' => 2]) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php foreach ($zwgTaxes as $tax): ?>
                                        <tr>
                                            <td style="padding: 4px 0; border: none;"><?= h($tax->name) ?> (Tax)</td>
                                            <td style="text-align: right; padding: 4px 0; color: #900000; border: none;">-ZWG <?= $this->Number->format($tax->amount, ['places' => 2]) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td style="padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none;">Subtotal ZWG</td>
                                            <td style="text-align: right; padding: 6px 0 10px 0; font-weight: bold; border-top: 1px solid #ddd; border-bottom: none; color: #900000;">-ZWG <?= $this->Number->format($payslip->zwg_deductions, ['places' => 2]) ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if(empty($usdDeductions) && empty($usdTaxes) && empty($zwgDeductions) && empty($zwgTaxes)): ?>
                                        <tr><td colspan="2" style="text-align: center; color: #888; font-style: italic; padding: 20px 0; border: none;">No deductions recorded</td></tr>
                                    <?php endif; ?>
                                </table>

                            </div>
                            <div style="background-color: #faf1f1; padding: 10px 15px; border-top: 2px solid #ccc; border-bottom: none;">
                                <table class="no-dt payslip-table" style="width: 100%; margin: 0; font-size: 14px;">
                                    <tr>
                                        <td style="font-weight: bold; color: #333; border: none; padding: 0;">Total Deductions (USD eq.)</td>
                                        <td style="text-align: right; font-weight: bold; color: #900000; border: none; padding: 0;">-<?= $this->Number->currency($payslip->deductions, 'USD') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Summary (Net Pays) -->
                <div style="border: 3px solid #e0e0e0; border-radius: 6px; padding: 20px; background-color: #fafbfc; margin-bottom: 20px;">
                    <h4 style="margin: 0 0 15px 0; color: #333; font-size: 16px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; text-align: center;">FINAL DISBURSEMENTS</h4>
                        
                    <div class="row" style="margin: 0; align-items: center;">
                        <div class="column column-50" style="padding: 0 20px 0 0; border-right: 2px dashed #ddd;">
                            <table class="no-dt payslip-table" style="width: 100%; margin: 0; border: none; font-size: 15px;">
                                <tr>
                                    <td style="border: none; padding: 4px 0; color: #555;">Net USD Pay:</td>
                                    <td style="border: none; padding: 4px 0; text-align: right; font-weight: bold; color: #2e6c80;"><?= $this->Number->currency($payslip->usd_net, 'USD') ?></td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 4px 0; color: #555;">Net ZWG Pay:</td>
                                    <td style="border: none; padding: 4px 0; text-align: right; font-weight: bold; color: #9b4dca;">ZWG <?= $this->Number->format($payslip->zwg_net, ['places' => 2]) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="column column-50" style="padding: 0 0 0 20px; text-align: left;">
                            <table class="no-dt payslip-table" style="width: 100%; margin: 0; border: none;">
                                <tr>
                                    <td style="border: none; padding: 0; font-size: 16px; font-weight: bold; color: #333;">Total Equiv Net (USD):</td>
                                    <td style="border: none; padding: 0; text-align: right; font-size: 22px; font-weight: bold; color: #4CAF50;"><?= $this->Number->currency($payslip->net_pay, 'USD') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; font-size: 11px; color: #999; border-top: 1px dashed #ccc; padding-top: 15px;">
                    This document was legally generated by the ESCerp Payroll module. Subject to auditing requirements and standards. No physical signature is required for validity.
                </div>

                <!-- PAGE BREAK FOR PRINT -->
                <div style="page-break-before: always; break-before: page; margin-top: 40px;"></div>

                <!-- LEAVE BALANCES (Page 2) -->
                <?php if (!empty($leaveBalances)): ?>
                <div style="border: 2px solid #e0e0e0; border-radius: 6px; padding: 20px; background-color: #fafbfc; margin-top: 20px;">
                    <h5 style="margin: 0 0 15px 0; color: #555; font-size: 16px; font-weight: bold; text-transform: uppercase; text-align: center;">Leave Status (<?= $payslip->generated_date->format('Y') ?>)</h5>
                    <table class="no-dt payslip-table" style="width: 100%; font-size: 14px; margin: 0; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #ccc; background-color: #f1f8fa;">
                                <th style="padding: 10px; text-align: left; border: none; color: #444;">Leave Type</th>
                                <th style="padding: 10px; text-align: center; border: none; color: #444;">Total Entitled</th>
                                <th style="padding: 10px; text-align: center; border: none; color: #444;">Days Used</th>
                                <th style="padding: 10px; text-align: right; border: none; color: #444;">Remaining Bal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaveBalances as $bal): ?>
                            <tr style="border-bottom: 1px solid #eaeaea;">
                                <td style="padding: 10px; border: none; color: #555;"><?= h($bal->leave_type->name) ?></td>
                                <td style="padding: 10px; text-align: center; border: none; color: #555;"><?= $this->Number->format($bal->days_entitled) ?></td>
                                <td style="padding: 10px; text-align: center; border: none; color: #555;"><?= $this->Number->format($bal->days_taken) ?></td>
                                <td style="padding: 10px; text-align: right; font-weight: bold; border: none; color: #2e6c80; font-size: 15px;"><?= $this->Number->format($bal->days_entitled - $bal->days_taken) ?> Days</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>