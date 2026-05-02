<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;

$PayslipsTable = TableRegistry::getTableLocator()->get('Payslips');
$PayslipItemsTable = TableRegistry::getTableLocator()->get('PayslipItems');

// Helper class/trait access is hard here, so we'll just replicate the logic briefly
function calculatePaye($gross) {
    if ($gross <= 300)    return 0.0;
    if ($gross <= 700)    return ($gross - 300) * 0.20;
    if ($gross <= 1500)   return 80 + ($gross - 700) * 0.25;
    if ($gross <= 3000)   return 280 + ($gross - 1500) * 0.30;
    return 730 + ($gross - 3000) * 0.35;
}

// Find payslips with no items or only 1-2 items (incomplete)
$payslips = $PayslipsTable->find()
    ->where(['Payslips.gross_pay >' => 0])
    ->contain(['PayslipItems'])
    ->all();

$fixedCount = 0;

foreach ($payslips as $payslip) {
    // If it has a full set of items, skip
    if (count($payslip->payslip_items) >= 4) {
        continue;
    }

    echo "Fixing/Refreshing Payslip ID: {$payslip->id} (Gross: {$payslip->gross_pay})\n";

    // Delete existing items to start fresh for these incomplete ones
    $PayslipItemsTable->deleteAll(['payslip_id' => $payslip->id]);

    $gross = (float)$payslip->gross_pay;
    $companyId = $payslip->company_id;

    $paye = calculatePaye($gross);
    $nssa = $gross * 0.045;
    if ($nssa > 31.50) $nssa = 31.50;
    $aids = $paye * 0.03;

    $itemsData = [
        ['name' => 'Basic Salary', 'amount' => $gross, 'item_type' => 'Earning', 'currency' => 'USD', 'is_permanent' => true],
        ['name' => 'PAYE', 'amount' => $paye, 'item_type' => 'Tax', 'currency' => 'USD', 'is_permanent' => false],
        ['name' => 'NSSA', 'amount' => $nssa, 'item_type' => 'Tax', 'currency' => 'USD', 'is_permanent' => false],
        ['name' => 'Aids Levy', 'amount' => $aids, 'item_type' => 'Tax', 'currency' => 'USD', 'is_permanent' => false],
    ];

    $items = [];
    foreach ($itemsData as $idat) {
        if ($idat['amount'] > 0) {
            $items[] = $PayslipItemsTable->newEntity(array_merge($idat, [
                'payslip_id' => $payslip->id,
                'company_id' => $companyId
            ]));
        }
    }

    if ($PayslipItemsTable->saveMany($items)) {
        // Update the summary fields on the payslip as well
        $totalDeductions = $paye + $nssa + $aids;
        $payslip->paye = $paye;
        $payslip->nssa = $nssa;
        $payslip->aids_levy = $aids;
        $payslip->deductions = $totalDeductions;
        $payslip->net_pay = $gross - $totalDeductions;
        $payslip->usd_deductions = $totalDeductions;
        $payslip->usd_net = $payslip->net_pay;
        
        $PayslipsTable->save($payslip);
        $fixedCount++;
    }
}

echo "Successfully refreshed $fixedCount payslips.\n";
