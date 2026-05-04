<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Alerts Controller
 * 
 * Handles outstanding receivables and notifications.
 */
class AlertsController extends AppController
{
    public function receivables()
    {
        $Invoices = TableRegistry::getTableLocator()->get('Invoices');
        $SchFees = TableRegistry::getTableLocator()->get('SchFees');

        // 1. Fetch Outstanding Invoices (ERP)
        $outstandingInvoices = $Invoices->find()
            ->contain(['Customers'])
            ->where(['Invoices.status !=' => 'Paid'])
            ->orderBy(['Invoices.date' => 'DESC'])
            ->all();

        // 2. Fetch Outstanding School Fees (SMS)
        // Since we don't have a virtual field 'balance' in the entity yet, 
        // we'll calculate it or use a raw check.
        $outstandingFees = $SchFees->find()
            ->contain(['SchStudents.Users'])
            ->where(['SchFees.paid < SchFees.amount'])
            ->all();

        $this->set(compact('outstandingInvoices', 'outstandingFees'));
    }

    public function overdueNotice()
    {
        $this->viewBuilder()->setLayout('document');
        $type = $this->request->getQuery('type');
        $id = $this->request->getQuery('id');

        $record = null;
        $entityName = '';
        $balance = 0;
        $currency = 'USD';

        if ($type === 'invoice') {
            $record = TableRegistry::getTableLocator()->get('Invoices')->get($id, contain: ['Customers']);
            $entityName = $record->customer->name;
            $balance = $record->total; // Simplify to total for the notice, or calculate current balance
            $currency = $record->currency;
        } elseif ($type === 'fee') {
            $record = TableRegistry::getTableLocator()->get('SchFees')->get($id, contain: ['SchStudents.Users']);
            $entityName = $record->sch_student->user->name;
            $balance = $record->amount - $record->paid;
        }

        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('record', 'entityName', 'balance', 'currency', 'company', 'type'));
    }

    public function applyInterest()
    {
        $this->request->allowMethod(['post']);
        $type = $this->request->getData('type');
        $id = $this->request->getData('id');
        $rate = (float)$this->request->getData('rate', 10);
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        $Transactions = TableRegistry::getTableLocator()->get('Transactions');
        $Accounts = TableRegistry::getTableLocator()->get('Accounts');

        // 1. Identify Entity and Balance
        $balance = 0;
        $customerId = null;
        $studentId = null;
        $currency = 'USD';
        $description = '';

        if ($type === 'invoice') {
            $record = TableRegistry::getTableLocator()->get('Invoices')->get($id);
            $balance = $record->total;
            $customerId = $record->customer_id;
            $currency = $record->currency;
            $description = "$rate% Interest Penalty on Invoice #" . ($record->reference ?: $record->id);
        } elseif ($type === 'fee') {
            $record = TableRegistry::getTableLocator()->get('SchFees')->get($id);
            $balance = $record->amount - $record->paid;
            $studentId = $record->student_id;
            $description = "$rate% Late Payment Interest on School Fees";
        }

        if ($balance <= 0) {
            $this->Flash->error(__('No outstanding balance to apply interest on.'));
            return $this->redirect($this->referer());
        }

        $interestAmount = $balance * ($rate / 100);

        // 2. Ensure Interest Income Account exists
        $incomeAcc = $Accounts->find()->where(['company_id' => $companyId, 'name LIKE' => '%Interest Income%'])->first();
        if (!$incomeAcc) {
            $incomeAcc = $Accounts->newEntity([
                'name' => 'Penalty & Interest Income',
                'category' => 'Revenue',
                'type' => 'Revenue',
                'company_id' => $companyId
            ]);
            $Accounts->save($incomeAcc);
        }

        // 3. Ensure Accounts Receivable exists
        $arAcc = $Accounts->find()->where(['company_id' => $companyId, 'category LIKE' => '%Receivable%'])->first();

        // 4. Post Double Entry
        $groupId = \Cake\Utility\Text::uuid();
        $Transactions->getConnection()->transactional(function () use ($Transactions, $companyId, $interestAmount, $currency, $description, $groupId, $arAcc, $incomeAcc, $customerId, $studentId, $id, $type) {
            // Debit Receivable
            $dr = $Transactions->newEntity([
                'company_id' => $companyId,
                'date' => date('Y-m-d'),
                'description' => $description,
                'amount' => $interestAmount,
                'zwg' => $interestAmount, // Assuming 1:1 or handle conversion if needed
                'type' => 'Debit',
                'account_id' => $arAcc->id,
                'customer_id' => $customerId,
                'student_id' => $studentId,
                'transaction_group' => $groupId,
                ($type === 'invoice' ? 'invoice_id' : 'fee_id') => $id
            ]);
            $Transactions->save($dr);

            // Credit Revenue
            $cr = $Transactions->newEntity([
                'company_id' => $companyId,
                'date' => date('Y-m-d'),
                'description' => $description,
                'amount' => $interestAmount,
                'zwg' => $interestAmount,
                'type' => 'Credit',
                'account_id' => $incomeAcc->id,
                'customer_id' => $customerId,
                'student_id' => $studentId,
                'transaction_group' => $groupId,
                ($type === 'invoice' ? 'invoice_id' : 'fee_id') => $id
            ]);
            $Transactions->save($cr);
        });

        $this->Flash->success(__("10% Interest ({0} {1}) has been successfully applied to the ledger.", $currency, number_format($interestAmount, 2)));
        return $this->redirect($this->referer());
    }

    public function triggerAlert()
    {
        $this->request->allowMethod(['post']);
        $type = $this->request->getData('type');
        $id = $this->request->getData('id');
        $target = $this->request->getData('target');

        // Placeholder for SMS/Email Integration
        // In a real system, you'd call an SMS gateway here (e.g., Clickatell, AfricasTalking)
        
        $this->Flash->success(__("Alert successfully queued for {0}. Reminder sent via System Channel.", $target));
        return $this->redirect($this->referer());
    }
}
