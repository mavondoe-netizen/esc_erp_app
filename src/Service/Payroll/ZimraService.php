<?php
declare(strict_types=1);

namespace App\Service\Payroll;

use Cake\ORM\Locator\LocatorAwareTrait;

class ZimraService
{
    use LocatorAwareTrait;

    /**
     * Generate Reconciliations for a Pay Period.
     * Iterates over all generated Payslips and records the PAYE amount.
     */
    public function generateMonthlyReconciliation(int $payPeriodId): bool
    {
        $payslips = $this->fetchTable('Payslips')->find()
            ->where(['pay_period_id' => $payPeriodId])
            ->all();

        $reconciliationsTable = $this->fetchTable('ZimraReconciliations');

        foreach ($payslips as $payslip) {
            $existing = $reconciliationsTable->find()
                ->where(['employee_id' => $payslip->employee_id, 'pay_period_id' => $payPeriodId])
                ->first();

            $payeAmount = $payslip->total_tax ?? 0.00;

            if (!$existing) {
                $record = $reconciliationsTable->newEntity([
                    'employee_id' => $payslip->employee_id,
                    'pay_period_id' => $payPeriodId,
                    'payroll_tax_amount' => $payeAmount,
                    'assessed_tax_amount' => 0.00,
                    'variance' => 0.00 - $payeAmount, // Assessed - Payroll
                    'status' => 'pending'
                ]);
                $reconciliationsTable->save($record);
            } else {
                if ($existing->status !== 'cleared') {
                    $existing->payroll_tax_amount = $payeAmount;
                    $existing->variance = $existing->assessed_tax_amount - $payeAmount;
                    $reconciliationsTable->save($existing);
                }
            }
        }
        return true;
    }

    /**
     * Clear variance by referencing a payment or receipt
     */
    public function clearVariance(int $reconciliationId, string $resolutionReference): bool
    {
        $reconciliationsTable = $this->fetchTable('ZimraReconciliations');
        $record = $reconciliationsTable->get($reconciliationId);

        $record->status = 'cleared';
        $record->cleared_date = date('Y-m-d');
        $record->cleared_via = $resolutionReference;
        
        return (bool)$reconciliationsTable->save($record);
    }
}
