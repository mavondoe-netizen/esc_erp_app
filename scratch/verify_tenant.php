<?php
require 'vendor/autoload.php';
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use App\Application;
use Cake\ORM\TableRegistry;

// Mock Tenant Configuration
Configure::write('Tenant.company_id', 2);

$Companies = TableRegistry::getTableLocator()->get('Companies');

echo "ROOT TABLE FILTERING TEST:\n";
$query = $Companies->find();
echo "SQL: " . $query->sql() . "\n";
$results = $query->all();
echo "Count with filter: " . $results->count() . "\n";

echo "\nBYPASSING FILTER TEST:\n";
$queryBypass = $Companies->find('all', ignoreTenant: true);
echo "SQL: " . $queryBypass->sql() . "\n";
$resultsBypass = $queryBypass->all();
echo "Count bypassing filter: " . $resultsBypass->count() . "\n";

echo "\nSTANDARD TABLE FILTERING TEST (Products):\n";
$Products = TableRegistry::getTableLocator()->get('Products');
$pQuery = $Products->find();
echo "SQL: " . $pQuery->sql() . "\n";
