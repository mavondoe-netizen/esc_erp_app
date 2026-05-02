<?php
/**
 * @var \App\View\AppView $this
 * @var array $report
 * @var array $totals
 * @var string $asOfDate
 * @var string $currency
 */
?>
<div class="reports index content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="color: #dc2626; margin-bottom: 5px;">Payables Aging Report</h2>
            <p style="color: #64748b;">Aged analysis of outstanding supplier bills as of <strong><?= h($asOfDate) ?></strong></p>
        </div>
        <div class="no-print">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-2 align-items-center']) ?>
                <div class="col-auto">
                    <?= $this->Form->control('as_of_date', ['label' => false, 'type' => 'date', 'value' => $asOfDate, 'class' => 'form-control form-control-sm']) ?>
                </div>
                <div class="col-auto">
                    <?= $this->Form->select('currency', ['USD' => 'USD', 'ZWG' => 'ZWG'], ['value' => $currency, 'class' => 'form-select form-select-sm']) ?>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-danger btn-sm">Generate</button>
                    <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm"><i class="fa fa-print"></i></button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="min-width: 800px;">
                <thead style="background: #fef2f2;">
                    <tr>
                        <th style="padding: 15px 20px;">Supplier Name</th>
                        <th class="text-end" style="width: 140px;">Current</th>
                        <th class="text-end" style="width: 140px;">31 - 60 Days</th>
                        <th class="text-end" style="width: 140px;">61 - 90 Days</th>
                        <th class="text-end" style="width: 140px;">Over 90 Days</th>
                        <th class="text-end" style="width: 150px; background: #fee2e2; font-weight: 700;">Total Payable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($report)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No outstanding payables found for the selected criteria.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($report as $supplier => $data): ?>
                        <tr>
                            <td style="padding: 15px 20px; font-weight: 600; color: #0f172a;"><?= h($supplier) ?></td>
                            <td class="text-end"><?= $data['current'] > 0 ? $this->Number->currency($data['current'], $currency) : '—' ?></td>
                            <td class="text-end text-warning"><?= $data['30'] > 0 ? $this->Number->currency($data['30'], $currency) : '—' ?></td>
                            <td class="text-end" style="color: #f97316;"><?= $data['60'] > 0 ? $this->Number->currency($data['60'], $currency) : '—' ?></td>
                            <td class="text-end text-danger"><?= $data['90'] > 0 ? $this->Number->currency($data['90'], $currency) : '—' ?></td>
                            <td class="text-end" style="background: #fef2f2; font-weight: 700; color: #dc2626;"><?= $this->Number->currency($data['total'], $currency) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot style="background: #fee2e2; font-weight: 800; border-top: 2px solid #fecaca;">
                    <tr>
                        <td style="padding: 15px 20px;">TOTALS</td>
                        <td class="text-end"><?= $this->Number->currency($totals['current'], $currency) ?></td>
                        <td class="text-end"><?= $this->Number->currency($totals['30'], $currency) ?></td>
                        <td class="text-end"><?= $this->Number->currency($totals['60'], $currency) ?></td>
                        <td class="text-end"><?= $this->Number->currency($totals['90'], $currency) ?></td>
                        <td class="text-end" style="background: #fecaca; font-size: 1.1rem; color: #991b1b;"><?= $this->Number->currency($totals['total'], $currency) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="no-print mt-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #16a34a !important;">
            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Current</small>
            <div class="h4 mb-0 fw-bold"><?= $totals['total'] > 0 ? round(($totals['current'] / $totals['total']) * 100, 1) : 0 ?>%</div>
        </div>
        <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #f59e0b !important;">
            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">31-60 Days</small>
            <div class="h4 mb-0 fw-bold"><?= $totals['total'] > 0 ? round(($totals['30'] / $totals['total']) * 100, 1) : 0 ?>%</div>
        </div>
        <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #f97316 !important;">
            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">61-90 Days</small>
            <div class="h4 mb-0 fw-bold"><?= $totals['total'] > 0 ? round(($totals['60'] / $totals['total']) * 100, 1) : 0 ?>%</div>
        </div>
        <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #dc2626 !important;">
            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Over 90 Days</small>
            <div class="h4 mb-0 fw-bold"><?= $totals['total'] > 0 ? round(($totals['90'] / $totals['total']) * 100, 1) : 0 ?>%</div>
        </div>
    </div>
</div>
