<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 * @var \App\Model\Entity\Company $company
 */

$this->assign('title', 'Payslip - ' . ($payslip->employee->first_name . ' ' . $payslip->employee->last_name));

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
            if ($currency === 'USD') $usdDeductions[] = $item; else $zwgEarnings[] = $item; // Fix: was zwgEarnings
        } elseif ($item->item_type === 'Tax') {
            if ($currency === 'USD') $usdTaxes[] = $item; else $zwgTaxes[] = $item;
        }
    }
}

// Re-sorting deductions because the previous loop had a bug
$usdDeductions = [];
$zwgDeductions = [];
if (!empty($payslip->payslip_items)) {
    foreach ($payslip->payslip_items as $item) {
        if ($item->item_type === 'Deduction') {
            if ($item->currency === 'USD') $usdDeductions[] = $item; else $zwgDeductions[] = $item;
        }
    }
}
?>

<div class="payslip-view">
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px;">
        <div>
            <?php if ($company->logo): ?>
                <img src="<?= $company->logo ?>" style="max-height: 70px; margin-bottom: 15px;">
            <?php else: ?>
                <h2 style="color: var(--primary-color); margin: 0; font-weight: 800;"><?= h($company->name) ?></h2>
            <?php endif; ?>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0; line-height: 1.5;">
                <?= h($company->address) ?><br>
                <?= h($company->email) ?> | <?= h($company->phone) ?>
            </p>
        </div>
        <div style="text-align: right;">
            <h1 style="margin: 0; color: #0f172a; font-size: 2.2rem; font-weight: 800; text-transform: uppercase; letter-spacing: -0.025em;">Payslip</h1>
            <p style="color: #64748b; font-weight: 600; margin-top: 5px;">#<?= str_pad((string)$payslip->id, 6, '0', STR_PAD_LEFT) ?></p>
            <div style="margin-top: 10px; background: #f1f5f9; padding: 5px 12px; border-radius: 20px; display: inline-block; font-size: 0.8rem; font-weight: 700; color: #475569;">
                PERIOD: <?= h($payslip->pay_period->name) ?>
            </div>
        </div>
    </div>

    <!-- Employee & Pay Info -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div style="background: #f8fafc; padding: 25px; border-radius: 12px; border: 1px solid #f1f5f9;">
            <h5 style="margin: 0 0 15px 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700;">Employee Information</h5>
            <div style="display: grid; grid-template-columns: auto 1fr; gap: 8px 15px; font-size: 0.95rem;">
                <span style="color: #64748b;">Name:</span>
                <span style="font-weight: 700; color: #0f172a;"><?= h($payslip->employee->first_name . ' ' . $payslip->employee->last_name) ?></span>
                
                <span style="color: #64748b;">ID / Code:</span>
                <span style="color: #0f172a;"><?= h($payslip->employee->employee_code) ?></span>
                
                <span style="color: #64748b;">Designation:</span>
                <span style="color: #0f172a;"><?= h($payslip->employee->designation) ?></span>

                <span style="color: #64748b;">SSN / NSSA:</span>
                <span style="color: #0f172a;"><?= h($payslip->employee->nssa_number) ?></span>
            </div>
        </div>
        <div style="background: #f8fafc; padding: 25px; border-radius: 12px; border: 1px solid #f1f5f9;">
            <h5 style="margin: 0 0 15px 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700;">Payment Details</h5>
            <div style="display: grid; grid-template-columns: auto 1fr; gap: 8px 15px; font-size: 0.95rem;">
                <span style="color: #64748b;">Generated:</span>
                <span style="color: #0f172a;"><?= $payslip->generated_date->format('M d, Y') ?></span>
                
                <span style="color: #64748b;">Exchange Rate:</span>
                <span style="color: #0f172a;">1 USD = <?= $this->Number->format($payslip->exchange_rate, ['places' => 4]) ?> ZWG</span>
                
                <span style="color: #64748b;">Status:</span>
                <span style="color: #16a34a; font-weight: 700;"><?= h($payslip->status) ?></span>
            </div>
        </div>
    </div>

    <!-- Earnings & Deductions Tables -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
        <!-- Earnings -->
        <div>
            <h4 style="background: var(--primary-color); color: white; margin: 0; padding: 12px 20px; border-radius: 8px 8px 0 0; font-size: 0.9rem; font-weight: 700; text-transform: uppercase;">Earnings</h4>
            <div style="border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; padding: 15px; min-height: 200px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <?php if (!empty($usdEarnings)): ?>
                        <tr><td colspan="2" style="padding: 10px 0 5px 0; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9;">USD Earnings</td></tr>
                        <?php foreach ($usdEarnings as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #0f172a;"><?= $this->Number->currency($item->amount, 'USD') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($zwgEarnings)): ?>
                        <tr><td colspan="2" style="padding: 15px 0 5px 0; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9;">ZWG Earnings</td></tr>
                        <?php foreach ($zwgEarnings as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #0f172a;">ZWG <?= $this->Number->format($item->amount, ['places' => 2]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
            <div style="margin-top: 15px; padding: 15px 20px; background: #f0fdf4; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; color: #166534; font-size: 0.85rem; text-transform: uppercase;">Total Gross (USD Eq.)</span>
                <span style="font-size: 1.1rem; font-weight: 800; color: #166534;"><?= $this->Number->currency($payslip->gross_pay, 'USD') ?></span>
            </div>
        </div>

        <!-- Deductions -->
        <div>
            <h4 style="background: #dc2626; color: white; margin: 0; padding: 12px 20px; border-radius: 8px 8px 0 0; font-size: 0.9rem; font-weight: 700; text-transform: uppercase;">Deductions & Taxes</h4>
            <div style="border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; padding: 15px; min-height: 200px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <?php if (!empty($usdDeductions) || !empty($usdTaxes)): ?>
                        <tr><td colspan="2" style="padding: 10px 0 5px 0; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9;">USD Deductions</td></tr>
                        <?php foreach ($usdDeductions as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #dc2626;">(<?= $this->Number->currency($item->amount, 'USD') ?>)</td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($usdTaxes as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?> (Tax)</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #dc2626;">(<?= $this->Number->currency($item->amount, 'USD') ?>)</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (!empty($zwgDeductions) || !empty($zwgTaxes)): ?>
                        <tr><td colspan="2" style="padding: 15px 0 5px 0; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9;">ZWG Deductions</td></tr>
                        <?php foreach ($zwgDeductions as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?></td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #dc2626;">(ZWG <?= $this->Number->format($item->amount, ['places' => 2]) ?>)</td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($zwgTaxes as $item): ?>
                            <tr>
                                <td style="padding: 8px 0; color: #334155;"><?= h($item->name) ?> (Tax)</td>
                                <td style="padding: 8px 0; text-align: right; font-weight: 600; color: #dc2626;">(ZWG <?= $this->Number->format($item->amount, ['places' => 2]) ?>)</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
            <div style="margin-top: 15px; padding: 15px 20px; background: #fef2f2; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 700; color: #991b1b; font-size: 0.85rem; text-transform: uppercase;">Total Deductions (USD Eq.)</span>
                <span style="font-size: 1.1rem; font-weight: 800; color: #991b1b;">(<?= $this->Number->currency($payslip->deductions, 'USD') ?>)</span>
            </div>
        </div>
    </div>

    <!-- Final Disbursement & Bank Details -->
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; margin-bottom: 40px; align-items: stretch;">
        <!-- Bank Details Section -->
        <div style="background: #f8fafc; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0;">
            <h5 style="margin: 0 0 20px 0; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #475569; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Banking & Disbursement Details</h5>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                <!-- USD Account -->
                <div>
                    <p style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">USD Account</p>
                    <?php if ($payslip->employee->usd_account): ?>
                        <div style="font-size: 0.85rem; line-height: 1.6;">
                            <div style="font-weight: 700; color: #0f172a;"><?= h($payslip->employee->usd_bank) ?></div>
                            <div style="color: #64748b; font-size: 0.8rem;">Branch: <?= h($payslip->employee->usd_branch) ?></div>
                            <div style="font-family: 'Roboto Mono', monospace; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; display: inline-block; margin-top: 4px; font-weight: 600;"><?= h($payslip->employee->usd_account) ?></div>
                        </div>
                    <?php else: ?>
                        <p style="font-size: 0.8rem; color: #94a3b8; font-style: italic;">Not provided</p>
                    <?php endif; ?>
                </div>
                <!-- ZWG Account -->
                <div>
                    <p style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">ZWG Account</p>
                    <?php if ($payslip->employee->zwg_account): ?>
                        <div style="font-size: 0.85rem; line-height: 1.6;">
                            <div style="font-weight: 700; color: #0f172a;"><?= h($payslip->employee->zwg_bank) ?></div>
                            <div style="color: #64748b; font-size: 0.8rem;">Branch: <?= h($payslip->employee->zwg_branch) ?></div>
                            <div style="font-family: 'Roboto Mono', monospace; background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; display: inline-block; margin-top: 4px; font-weight: 600;"><?= h($payslip->employee->zwg_account) ?></div>
                        </div>
                    <?php else: ?>
                        <p style="font-size: 0.8rem; color: #94a3b8; font-style: italic;">Not provided</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Net Pay Summary -->
        <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%); padding: 30px; border-radius: 12px; color: white; display: flex; flex-direction: column; justify-content: center;">
            <div style="font-size: 0.8rem; text-transform: uppercase; font-weight: 700; opacity: 0.8; letter-spacing: 0.05em; margin-bottom: 10px;">Net Pay Summary</div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 1rem;">
                <span>Net USD:</span>
                <span style="font-weight: 700;"><?= $this->Number->currency($payslip->usd_net, 'USD') ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 15px;">
                <span>Net ZWG:</span>
                <span style="font-weight: 700;">ZWG <?= $this->Number->format($payslip->zwg_net, ['places' => 2]) ?></span>
            </div>

            <div style="text-align: right;">
                <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; opacity: 0.9; margin-bottom: 2px;">Total Net (USD Eq.)</div>
                <div style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.02em;"><?= $this->Number->currency($payslip->net_pay, 'USD') ?></div>
            </div>
        </div>
    </div>

    <!-- Footer Disclaimer -->
    <div style="text-align: center; border-top: 1px solid #f1f5f9; padding-top: 25px; color: #94a3b8; font-size: 0.75rem; line-height: 1.6;">
        <p style="margin: 0;">This is a computer-generated document and does not require a physical signature. Issued by <strong><?= h($company->name) ?></strong> Payroll Department.</p>
        <p style="margin: 5px 0 0 0;">CONFIDENTIAL: This payslip is intended solely for the named employee.</p>
    </div>
</div>