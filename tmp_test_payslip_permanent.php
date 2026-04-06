<?php
require 'vendor/autoload.php';
require 'config/paths.php';
require 'config/bootstrap.php';

use Cake\ORM\Locator\LocatorAwareTrait;

class TestSavePermanent {
    use LocatorAwareTrait;

    public function run() {
        $table = $this->fetchTable('Payslips');
        
        $data = [
            'employee_id' => 1,
            'pay_period_id' => 1,
            'generated_date' => date('Y-m-d'),
            'gross_pay' => 1500,
            'deductions' => 200,
            'net_pay' => 1300,
            'payslip_items' => [
                [
                    'item_type' => 'Earning',
                    'name' => 'Salary',
                    'amount' => 1500,
                    'is_permanent' => 1 // True
                ],
                [
                    'item_type' => 'Deduction',
                    'name' => 'Loan Repayment',
                    'amount' => 200,
                    'is_permanent' => 0 // False
                ]
            ]
        ];
        
        $entity = $table->newEntity($data, ['associated' => ['PayslipItems']]);
        if ($entity->hasErrors()) {
            echo "Validation errors before save:\n";
            print_r($entity->getErrors());
            return;
        }

        $result = $table->save($entity);
        if (!$result) {
            echo "Save failed. Errors:\n";
            print_r($entity->getErrors());
        } else {
            echo "Save successful! ID: " . $result->id . "\n";
            
            // Re-fetch to verify is_permanent saved correctly
            $saved = $table->get($result->id, ['contain' => ['PayslipItems']]);
            foreach($saved->payslip_items as $item) {
                echo "Item: {$item->name}, Permanent: " . ($item->is_permanent ? 'Yes' : 'No') . "\n";
            }
        }
    }
}

$test = new TestSavePermanent();
$test->run();
