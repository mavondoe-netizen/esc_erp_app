<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;
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

$html = $view->render('Estimates/view');

$lines = explode("\n", $html);
$start = false;
$count = 0;
foreach ($lines as $i => $line) {
    if (strpos($line, '<div class="document-actions no-print">') !== false) {
        $start = true;
    }
    if ($start) {
        echo ($i + 1) . ": " . $line . "\n";
        $count++;
        if ($count > 25) {
            break;
        }
    }
}
