<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class SearchController extends AppController
{
    public function index()
    {
        $q = $this->request->getQuery('q');
        $results = [];

        if (!empty($q)) {
            $q = trim((string)$q);

            // 1. Employees
            $results['Employees'] = $this->fetchTable('Employees')->find()
                ->where(['OR' => [
                    'first_name LIKE' => "%$q%",
                    'last_name LIKE' => "%$q%",
                    'email LIKE' => "%$q%",
                    'employee_code LIKE' => "%$q%"
                ]])
                ->limit(10)
                ->all();

            // 2. Users
            $results['Users'] = $this->fetchTable('Users')->find()
                ->where(['email LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 3. Customers
            $results['Customers'] = $this->fetchTable('Customers')->find()
                ->where(['name LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 4. Deals
            $results['Deals'] = $this->fetchTable('Deals')->find()
                ->where(['OR' => [
                    'name LIKE' => "%$q%",
                    'description LIKE' => "%$q%"
                ]])
                ->limit(10)
                ->all();

            // 5. Invoices
            $results['Invoices'] = $this->fetchTable('Invoices')->find()
                ->where(['description LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 6. Bills
            $results['Bills'] = $this->fetchTable('Bills')->find()
                ->where(['description LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 7. Estimates
            $results['Estimates'] = $this->fetchTable('Estimates')->find()
                ->where(['description LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 8. Debit Notes
            $results['DebitNotes'] = $this->fetchTable('DebitNotes')->find()
                ->where(['description LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 9. Credit Notes
            $results['CreditNotes'] = $this->fetchTable('CreditNotes')->find()
                ->where(['description LIKE' => "%$q%"])
                ->limit(10)
                ->all();

            // 10. Tasks
             $results['Tasks'] = $this->fetchTable('Tasks')->find()
             ->where(['OR' => [
                 'name LIKE' => "%$q%",
                 'description LIKE' => "%$q%"
             ]])
             ->limit(10)
             ->all();

            // 8. Products
            $results['Products'] = $this->fetchTable('Products')->find()
                ->where(['name LIKE' => "%$q%"])
                ->limit(10)
                ->all();
        }

        // Filter out empty result sets
        $results = array_filter($results, function($resultSet) {
            return count($resultSet) > 0;
        });

        $this->set(compact('results', 'q'));
    }
}
