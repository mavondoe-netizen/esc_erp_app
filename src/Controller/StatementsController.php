<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\DateTime;

/**
 * Statements Controller
 * 
 * Generates monthly financial statements for Receivables and Payables.
 */
class StatementsController extends AppController
{
    public function index()
    {
        $customers = TableRegistry::getTableLocator()->get('Customers')->find('list')->all();
        $suppliers = TableRegistry::getTableLocator()->get('Suppliers')->find('list')->all();
        $students  = TableRegistry::getTableLocator()->get('SchStudents')->find('list', [
            'keyField' => 'id',
            'valueField' => function($student) {
                return $student->user->name ?? 'Student #' . $student->id;
            }
        ])->contain(['Users'])->all();

        $this->set(compact('customers', 'suppliers', 'students'));
    }

    public function view()
    {
        $this->viewBuilder()->setLayout('document');
        
        $type = $this->request->getQuery('type');
        $id = $this->request->getQuery('id');
        $startDateStr = $this->request->getQuery('start_date', date('Y-m-01'));
        $endDateStr = $this->request->getQuery('end_date', date('Y-m-t'));

        $startDate = new DateTime($startDateStr);
        $endDate = new DateTime($endDateStr);

        $Transactions = TableRegistry::getTableLocator()->get('Transactions');
        $entity = null;
        $entityName = '';
        $query = $Transactions->find()->where([
            'Transactions.date >=' => $startDate->format('Y-m-d'),
            'Transactions.date <=' => $endDate->format('Y-m-d'),
        ])->orderBy(['Transactions.date' => 'ASC']);

        // Filter by Entity
        if ($type === 'customer') {
            $entity = TableRegistry::getTableLocator()->get('Customers')->get($id);
            $entityName = $entity->name;
            $query->where(['Transactions.customer_id' => $id]);
        } elseif ($type === 'supplier') {
            $entity = TableRegistry::getTableLocator()->get('Suppliers')->get($id);
            $entityName = $entity->name;
            $query->where(['Transactions.supplier_id' => $id]);
        } elseif ($type === 'student') {
            $entity = TableRegistry::getTableLocator()->get('SchStudents')->get($id, contain: ['Users']);
            $entityName = $entity->user->name;
            // For students, we might filter by student_id if transactions are linked, 
            // otherwise we might need a custom mapping. For now, assuming student_id exists in transactions if linked.
            $query->where(['Transactions.student_id' => $id]);
        }

        $transactions = $query->all();

        // Calculate Opening Balance
        $openingQuery = $Transactions->find()
            ->select(['total' => $Transactions->find()->func()->sum('CASE WHEN type="Debit" THEN amount ELSE -amount END')])
            ->where(['Transactions.date <' => $startDate->format('Y-m-d')]);

        if ($type === 'customer') $openingQuery->where(['Transactions.customer_id' => $id]);
        elseif ($type === 'supplier') $openingQuery->where(['Transactions.supplier_id' => $id]);
        elseif ($type === 'student') $openingQuery->where(['Transactions.student_id' => $id]);

        $openingBalance = (float)$openingQuery->first()->total;

        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('transactions', 'entityName', 'entity', 'startDate', 'endDate', 'openingBalance', 'company', 'type'));
    }

    public function emailStatement()
    {
        $this->request->allowMethod(['post']);
        
        $type = $this->request->getData('type');
        $id = $this->request->getData('id');
        $startDateStr = $this->request->getData('start_date', date('Y-m-01'));
        $endDateStr = $this->request->getData('end_date', date('Y-m-t'));

        $startDate = new DateTime($startDateStr);
        $endDate = new DateTime($endDateStr);

        // Fetch Data (Refactor this into a protected method if needed, for now reuse logic)
        $Transactions = TableRegistry::getTableLocator()->get('Transactions');
        $entity = null;
        $recipientEmail = '';
        
        if ($type === 'customer') {
            $entity = TableRegistry::getTableLocator()->get('Customers')->get($id, contain: ['Contacts']);
            $recipientEmail = $entity->contact->email ?? '';
        } elseif ($type === 'supplier') {
            $entity = TableRegistry::getTableLocator()->get('Suppliers')->get($id, contain: ['Contacts']);
            $recipientEmail = $entity->contact->email ?? '';
        } elseif ($type === 'student') {
            $entity = TableRegistry::getTableLocator()->get('SchStudents')->get($id, contain: ['Users']);
            $recipientEmail = $entity->user->email ?? '';
        }

        if (empty($recipientEmail)) {
            $this->Flash->error(__('No email address found for this entity.'));
            return $this->redirect($this->referer());
        }

        // Logic to fetch transactions and balances (duplicated for speed, should be shared)
        $query = $Transactions->find()->where([
            'Transactions.date >=' => $startDate->format('Y-m-d'),
            'Transactions.date <=' => $endDate->format('Y-m-d'),
        ])->orderBy(['Transactions.date' => 'ASC']);

        if ($type === 'customer') $query->where(['Transactions.customer_id' => $id]);
        elseif ($type === 'supplier') $query->where(['Transactions.supplier_id' => $id]);
        elseif ($type === 'student') $query->where(['Transactions.student_id' => $id]);

        $transactions = $query->all();

        $openingQuery = $Transactions->find()
            ->select(['total' => $Transactions->find()->func()->sum('CASE WHEN type="Debit" THEN amount ELSE -amount END')])
            ->where(['Transactions.date <' => $startDate->format('Y-m-d')]);

        if ($type === 'customer') $openingQuery->where(['Transactions.customer_id' => $id]);
        elseif ($type === 'supplier') $openingQuery->where(['Transactions.supplier_id' => $id]);
        elseif ($type === 'student') $openingQuery->where(['Transactions.student_id' => $id]);

        $openingBalance = (float)$openingQuery->first()->total;
        
        $totalDr = 0; $totalCr = 0;
        foreach($transactions as $t) {
            if ($t->type === 'Debit') $totalDr += $t->amount;
            else $totalCr += $t->amount;
        }
        $closingBalance = $openingBalance + $totalDr - $totalCr;

        // Send Email
        try {
            $mailer = new \App\Mailer\StatementMailer();
            $mailer->sendStatement($entity, $transactions, $openingBalance, $closingBalance, $startDate, $endDate, $recipientEmail);
            $this->Flash->success(__("Statement successfully emailed to {0}.", $recipientEmail));
        } catch (\Exception $e) {
            $this->Flash->error(__("Failed to send email: " . $e->getMessage()));
        }

        return $this->redirect($this->referer());
    }
}
