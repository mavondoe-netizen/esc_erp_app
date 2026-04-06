<?php
require 'vendor/autoload.php';
require 'config/paths.php';
require 'config/bootstrap.php';

use Cake\ORM\Locator\LocatorAwareTrait;

class TestSave {
    use LocatorAwareTrait;

    public function run() {
        $table = $this->fetchTable('Payslips');
        
        $data = [
            'employee_id' => 1,
            'pay_period_id' => 1,
            'generated_date' => date('Y-m-d'),
            'gross_pay' => 1000,
            'deductions' => 100,
            'net_pay' => 900,
            'basic_salary' => 0,
            'allowances' => 0,
            'bonuses' => 0,
            'overtime' => 0,
            'benefits' => 0,
            'pension' => 0,
            'nssa' => 0,
            'medical_aid' => 0,
            'medical_expenses' => 0,
            'taxable_income' => 0,
            'paye' => 0,
            'tax_credits' => 0,
            'aids_levy' => 0,
            'total_tax' => 0,
        ];
        
        $entity = $table->newEntity($data);
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
            $table->delete($result); // cleanup
        }
    }
}

$test = new TestSave();
$test->run();
