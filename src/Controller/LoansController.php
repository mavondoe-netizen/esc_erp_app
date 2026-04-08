<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\Loans\DisbursementService;
use App\Service\Loans\RepaymentService;
use App\Service\Loans\InterestService;
use App\Service\Loans\ScoringService;

class LoansController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $query = $this->fetchTable('Loans')
            ->find()
            ->contain(['LoanClients', 'LoanProducts'])
            ->order(['Loans.created' => 'DESC']);
        $loans = $this->paginate($query);
        $this->set(compact('loans'));
    }

    public function view($id = null)
    {
        $loan = $this->fetchTable('Loans')->get($id, [
            'contain' => ['LoanClients', 'LoanProducts', 'LoanSchedules', 'LoanRepayments', 'LoanDisbursements', 'LoanRestructures', 'DelinquencyFlags'],
        ]);

        $interestService = new InterestService();
        $payoffAmount    = $interestService->getPayoffAmount($loan);

        $this->set(compact('loan', 'payoffAmount'));
    }

    /** Show disbursement form and process */
    public function disburse($id = null)
    {
        $loan = $this->fetchTable('Loans')->get($id, ['contain' => ['LoanClients']]);
        if ($loan->status !== 'pending_disbursement') {
            $this->Flash->error('This loan is not pending disbursement.');
            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->request->is('post')) {
            $data      = $this->request->getData();
            $identity  = $this->request->getAttribute('identity');

            try {
                $service = new DisbursementService();
                $service->disburse(
                    $loan,
                    (int)$data['account_id'],
                    $data['method'] ?? 'bank',
                    $data['bank_reference'] ?? '',
                    $identity->id ?? 0
                );
                $this->Flash->success('Loan disbursed successfully. Repayment schedule generated.');
                return $this->redirect(['action' => 'view', $id]);
            } catch (\Exception $e) {
                $this->Flash->error('Disbursement failed: ' . $e->getMessage());
            }
        }

        $accounts = $this->fetchTable('Accounts')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $this->set(compact('loan', 'accounts'));
    }

    /** Record a repayment */
    public function repay($id = null)
    {
        $loan = $this->fetchTable('Loans')->get($id, ['contain' => ['LoanClients']]);
        if (!in_array($loan->status, ['active', 'delinquent'])) {
            $this->Flash->error('Cannot accept repayment on this loan.');
            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->request->is('post')) {
            $data     = $this->request->getData();
            $identity = $this->request->getAttribute('identity');
            try {
                $service = new RepaymentService();
                $service->receive(
                    $loan,
                    (float)$data['amount'],
                    $data['currency'] ?? $loan->currency,
                    (int)$data['account_id'],
                    $data['source'] ?? 'cash',
                    $data['payment_date'] ?? date('Y-m-d'),
                    $identity->id ?? 0,
                    $data['reference'] ?? ''
                );
                $this->Flash->success('Payment received and allocated successfully.');
                return $this->redirect(['action' => 'view', $id]);
            } catch (\Exception $e) {
                $this->Flash->error('Repayment failed: ' . $e->getMessage());
            }
        }

        $accounts = $this->fetchTable('Accounts')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $this->set(compact('loan', 'accounts'));
    }

    /** Recompute the credit score for this loan's client */
    public function rescore($id = null)
    {
        $this->request->allowMethod(['post']);
        $loan  = $this->fetchTable('Loans')->get($id);
        $score = (new ScoringService())->calculate($loan->client_id);
        $this->Flash->success("Credit score updated: {$score->score} ({$score->grade})");
        return $this->redirect(['action' => 'view', $id]);
    }
}
