<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;

$companyId = 199; // The company we saw in previous turns
$Payslips = TableRegistry::getTableLocator()->get('Payslips');
$PayPeriods = TableRegistry::getTableLocator()->get('PayPeriods');

$latestPeriod = $PayPeriods->find()
    ->where(['PayPeriods.company_id' => $companyId])
    ->order(['PayPeriods.end_date' => 'DESC'])
    ->first();

echo "Latest Period: " . ($latestPeriod ? $latestPeriod->name . " (ID: " . $latestPeriod->id . ")" : "None") . "\n";

if ($latestPeriod) {
    $summaries = $Payslips->find()
        ->select([
            'gross' => $Payslips->find()->func()->sum('gross_pay'),
            'deduc' => $Payslips->find()->func()->sum('deductions'),
            'net'   => $Payslips->find()->func()->sum('net_pay')
        ])
        ->where(['Payslips.pay_period_id' => $latestPeriod->id])
        ->first();

    echo "Summaries for Period {$latestPeriod->id}:\n";
    print_r($summaries->toArray());
}

$chartData = [];
for ($i = 5; $i >= 0; $i--) {
    $monthStart = date('Y-m-01', strtotime("-$i months"));
    $monthEnd   = date('Y-m-t', strtotime("-$i months"));
    $label      = date('M', strtotime("-$i months"));
    
    $monthlySummary = $Payslips->find()
        ->select([
            'gross' => $Payslips->find()->func()->sum('gross_pay'),
            'deduc' => $Payslips->find()->func()->sum('deductions')
        ])
        ->where([
            'Payslips.company_id' => $companyId,
            'Payslips.generated_date >=' => $monthStart,
            'Payslips.generated_date <=' => $monthEnd
        ])
        ->first();
    
    echo "$label: Gross=" . ($monthlySummary->get('gross') ?: 0) . ", Deduc=" . ($monthlySummary->get('deduc') ?: 0) . "\n";
}
