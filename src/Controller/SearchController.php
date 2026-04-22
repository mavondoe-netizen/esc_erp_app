<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Search Controller
 *
 * Global search across the application.
 */
class SearchController extends AppController
{
    /**
     * Global search index.
     *
     * @return void
     */
    public function index()
    {
        $query = $this->request->getQuery('q', '');
        $companyId = $this->request->getAttribute('company_id');

        $results = [];

        if (!empty(trim($query))) {
            $likeQ = '%' . $query . '%';

            // Search Customers
            $Customers = TableRegistry::getTableLocator()->get('Customers');
            $customers = $Customers->find()
                ->where([
                    'Customers.company_id' => $companyId,
                    'OR' => [
                        'Customers.name LIKE' => $likeQ,
                        'Customers.email LIKE' => $likeQ,
                    ],
                ])
                ->limit(5)
                ->all();

            foreach ($customers as $c) {
                $results[] = ['type' => 'Customer', 'label' => $c->name, 'url' => '/customers/view/' . $c->id];
            }

            // Search Suppliers
            $Suppliers = TableRegistry::getTableLocator()->get('Suppliers');
            $suppliers = $Suppliers->find()
                ->where([
                    'Suppliers.company_id' => $companyId,
                    'OR' => [
                        'Suppliers.name LIKE' => $likeQ,
                        'Suppliers.email LIKE' => $likeQ,
                    ],
                ])
                ->limit(5)
                ->all();

            foreach ($suppliers as $s) {
                $results[] = ['type' => 'Supplier', 'label' => $s->name, 'url' => '/suppliers/view/' . $s->id];
            }

            // Search Invoices
            $Invoices = TableRegistry::getTableLocator()->get('Invoices');
            $invoices = $Invoices->find()
                ->where([
                    'Invoices.company_id' => $companyId,
                    'Invoices.reference LIKE' => $likeQ,
                ])
                ->limit(5)
                ->all();

            foreach ($invoices as $inv) {
                $results[] = ['type' => 'Invoice', 'label' => $inv->reference, 'url' => '/invoices/view/' . $inv->id];
            }

            // Search Products
            $Products = TableRegistry::getTableLocator()->get('Products');
            $products = $Products->find()
                ->where([
                    'Products.company_id' => $companyId,
                    'Products.name LIKE' => $likeQ,
                ])
                ->limit(5)
                ->all();

            foreach ($products as $p) {
                $results[] = ['type' => 'Product', 'label' => $p->name, 'url' => '/products/view/' . $p->id];
            }
        }

        $this->set(compact('query', 'results'));
    }
}
