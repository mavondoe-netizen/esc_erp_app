<?php
declare(strict_types=1);

namespace App\Test\Scratch;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Scratch script to verify TenantAware behavior.
 */

// Mock the tenant ID
$mockTenantId = 199;
Configure::write('Tenant.company_id', $mockTenantId);

echo "Testing Tenant Awareness for Employees module...\n";
echo "Mock Tenant ID: $mockTenantId\n\n";

$tables = [
    'Employees',
    'EmployeeProfiles',
    'SalaryStructures',
    'LeaveApplications',
    'LeaveBalances'
];

foreach ($tables as $tableName) {
    try {
        echo "Testing $tableName...\n";
        $table = TableRegistry::getTableLocator()->get($tableName);
        
        // 1. Test Finding
        $query = $table->find();
        $sql = $query->sql();
        echo "  - Find SQL: " . $sql . "\n";
        
        if (strpos($sql, "company_id = ?") !== false || strpos($sql, "company_id` = ?") !== false) {
            echo "  [PASS] Find query restricted by company_id.\n";
        } else {
            echo "  [FAIL] Find query NOT restricted by company_id.\n";
        }

        // 2. Test Stamping (beforeSave)
        $entity = $table->newEmptyEntity();
        // Set required fields if any (this is just a mock save)
        $table->dispatchEvent('Model.beforeSave', ['entity' => $entity, 'options' => new \ArrayObject()]);
        
        if ($entity->get('company_id') === $mockTenantId) {
            echo "  [PASS] Entity auto-stamped with company_id on save.\n";
        } else {
            echo "  [FAIL] Entity NOT stamped with company_id. Value: " . var_export($entity->get('company_id'), true) . "\n";
        }
        echo "\n";
        
    } catch (\Exception $e) {
        echo "  [ERROR] " . $e->getMessage() . "\n\n";
    }
}
