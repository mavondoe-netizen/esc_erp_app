<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;
use Cake\View\View;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

$routes = Router::createRouteBuilder('/');
$routeConfig = require 'config/routes.php';
$routeConfig($routes);

$estimatesTable = TableRegistry::getTableLocator()->get('Estimates');
$estimate = $estimatesTable->find()
    ->contain(['Customers', 'EstimateItems' => ['Accounts', 'Products']])
    ->first();

$companiesTable = TableRegistry::getTableLocator()->get('Companies');
$company = $companiesTable->get($estimate->company_id);

$request = new ServerRequest([
    'params' => [
        'controller' => 'Estimates',
        'action' => 'view',
        'plugin' => null,
    ]
]);

$viewBuilder = new \Cake\View\ViewBuilder();
$viewBuilder->setLayout('document');
$viewBuilder->setVars(compact('estimate', 'company'));
$view = $viewBuilder->build($request);

try {
    $html = $view->render('Estimates/view');
    echo "### RENDER SUCCESSFUL!\n";
    // Check if actions block contains the Convert to Invoice button
    if (strpos($html, 'Convert to Invoice') !== false) {
        echo "Found 'Convert to Invoice' button!\n";
    } else {
        echo "WARNING: 'Convert to Invoice' button NOT found in output!\n";
    }
    
    // Find the actions section in HTML and print it
    if (preg_match('/<div class="document-actions no-print">.*?<\/div>/s', $html, $matches)) {
        echo "### Actions wrapper HTML:\n";
        echo $matches[0] . "\n";
    } else {
        echo "WARNING: actions wrapper HTML not matched!\n";
    }

    // Let's print where the products are rendered
    if (preg_match('/<tbody>.*?<\/tbody>/s', $html, $matches)) {
        echo "### Table body HTML:\n";
        echo $matches[0] . "\n";
    }

} catch (\Throwable $e) {
    echo "RENDER ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
