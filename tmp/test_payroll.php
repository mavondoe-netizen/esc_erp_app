<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/paths.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';

use App\Service\PayrollService;

$service = new PayrollService();


// Mock items based on the sample data we inserted
$items = [
    ['item_type' => 'Earning', 'name' => 'Basic Salary', 'amount' => '1500.00'], // $1500 taxable/nssa
    ['item_type' => 'Earning', 'name' => 'Housing Allowance', 'amount' => '200.00'], // taxable, no nssa
    ['item_type' => 'Deduction', 'name' => 'Medical Aid', 'amount' => '50.00']
];

$taxes = $service->calculateFromItems($items);

echo "Calculation Results for \$1500 Basic + \$200 Housing Allowance:\n";
foreach ($taxes as $tax) {
    echo $tax['name'] . ": $" . number_format($tax['amount'], 2) . "\n";
}

// Expected NSSA = 700 * 4.5% = 31.50
// Expected Pension = 10% of 1500 = 150.00
// Expected Taxable = (1500 + 200) - 150 - 31.50 = 1700 - 181.50 = 1518.50
// Expected PAYE on 1518.50: Tax Bracket limit 1000 to 2000 is 30% rate, $85 deduction
// Tax = (1518.50 * 0.30) - 85 = 455.55 - 85 = 370.55
// Credits = 50 * 0.5 = 25
// Final PAYE = 370.55 - 25 = 345.55
// Aids Levy = 345.55 * 0.03 = 10.37 (rounded)
