<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Cake\Utility\Text;

/**
 * PayPeriods Controller
 *
 * @property \App\Model\Table\PayPeriodsTable $PayPeriods
 */
class PayPeriodsController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $query = $this->PayPeriods->find()
            ->order(['start_date' => 'DESC']);
        $payPeriods = $this->paginate($query);

        $this->set(compact('payPeriods'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $payPeriod = $this->PayPeriods->get($id, contain: [
            'Payslips' => ['Employees'],
            'Transactions' => ['Accounts']
        ]);
        $this->set(compact('payPeriod'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $payPeriod = $this->PayPeriods->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($data['month']) && !empty($data['year'])) {
                $month = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
                $year = $data['year'];
                $data['name'] = date('F Y', strtotime("$year-$month-01"));
                $data['start_date'] = "$year-$month-01";
                $data['end_date'] = date('Y-m-t', strtotime("$year-$month-01"));
            }
            $payPeriod = $this->PayPeriods->patchEntity($payPeriod, $data);
            
            if ($this->request->getQuery('popup')) {
                if ($this->PayPeriods->save($payPeriod)) {
                    $this->set('popupResult', ['id' => $payPeriod->id, 'name' => $payPeriod->name]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($this->PayPeriods->save($payPeriod)) {
                $this->Flash->success(__('The pay period has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            \Cake\Log\Log::error('PayPeriod add failed: ' . json_encode($payPeriod->getErrors()));
            $this->Flash->error(__('The pay period could not be saved. Please, try again.'));
        }
        $this->set(compact('payPeriod'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $payPeriod = $this->PayPeriods->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (!empty($data['month']) && !empty($data['year'])) {
                $month = str_pad($data['month'], 2, '0', STR_PAD_LEFT);
                $year = $data['year'];
                $data['name'] = date('F Y', strtotime("$year-$month-01"));
                $data['start_date'] = "$year-$month-01";
                $data['end_date'] = date('Y-m-t', strtotime("$year-$month-01"));
            }
            $payPeriod = $this->PayPeriods->patchEntity($payPeriod, $data);
            if ($this->PayPeriods->save($payPeriod)) {
                $this->Flash->success(__('The pay period has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pay period could not be saved. Please, try again.'));
        }
        $this->set(compact('payPeriod'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payPeriod = $this->PayPeriods->get($id);
        if ($this->PayPeriods->delete($payPeriod)) {
            $this->Flash->success(__('The pay period has been deleted.'));
        } else {
            $this->Flash->error(__('The pay period could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Rollover method: Create the next chronological pay period.
     */
    public function rollover()
    {
        $this->request->allowMethod(['post']);
        
        $companyId = $this->request->getAttribute('company_id');

        $latest = $this->PayPeriods->find()
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['end_date' => 'DESC'])
            ->first();

        if (!$latest) {
            $startDate = new FrozenDate('first day of this month');
            $endDate = new FrozenDate('last day of this month');
        } else {
            // Close the latest period and post transactions
            $latest->status = 'Closed';
            if (!$this->PayPeriods->save($latest)) {
                \Cake\Log\Log::error('Latest PayPeriod save failed: ' . json_encode($latest->getErrors()));
                $this->Flash->error(__('Could not close the current pay period.'));
                return $this->redirect(['action' => 'index']);
            }
            
            // Post transactions
            $this->_postPayrollToLedger($latest->id, $companyId);
            
            $startDate = new FrozenDate($latest->end_date->addDays(1));
            $endDate = $startDate->modify('last day of this month');
        }

        $name = $startDate->format('F Y');

        $payPeriod = $this->PayPeriods->newEntity([
            'company_id' => $companyId,
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'Open'
        ]);

        if ($this->PayPeriods->save($payPeriod)) {
            $this->Flash->success(__("Pay period '{0}' has been created.", $name));
            return $this->redirect(['action' => 'view', $payPeriod->id]);
        }

        \Cake\Log\Log::error('PayPeriod save failed: ' . json_encode($payPeriod->getErrors()));
        $this->Flash->error(__('Could not rollover to next month.'));
        return $this->redirect(['action' => 'index']);
    }

    private function _postPayrollToLedger(int $payPeriodId, int $companyId): void
    {
        $Accounts = $this->fetchTable('Accounts');
        $Transactions = $this->fetchTable('Transactions');
        $Payslips = $this->fetchTable('Payslips');
        $Earnings = $this->fetchTable('Earnings');
        $Deductions = $this->fetchTable('Deductions');

        // Ensure "Salaries Payable" exists
        $salariesPayable = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.name LIKE' => '%Salaries Payable%'])
            ->first();
            
        if (!$salariesPayable) {
            $salariesPayable = $Accounts->newEntity([
                'company_id' => $companyId,
                'name' => 'Salaries Payable',
                'type' => 'Liability',
                'category' => 'Payroll Payables',
                'currency' => 'USD',
                'balance' => 0
            ]);
            $Accounts->save($salariesPayable);
        }

        $payPeriod = $this->PayPeriods->get($payPeriodId);
        $date = $payPeriod->end_date;

        $payePayable = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.name LIKE' => '%PAYE Payable%'])
            ->first();
            
        $nssaPayable = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.name LIKE' => '%NSSA Payable%'])
            ->first();

        // Get earning and deduction account maps, filtered by the current company's accounts
        $earningAccounts = $Earnings->find()
            ->select(['Earnings.name', 'Earnings.account_id'])
            ->innerJoinWith('Accounts', function ($q) use ($companyId) {
                return $q->where(['Accounts.company_id' => $companyId]);
            })
            ->all()
            ->combine('name', 'account_id')
            ->toArray();

        $deductionAccounts = $Deductions->find()
            ->select(['Deductions.name', 'Deductions.account_id'])
            ->innerJoinWith('Accounts', function ($q) use ($companyId) {
                return $q->where(['Accounts.company_id' => $companyId]);
            })
            ->all()
            ->combine('name', 'account_id')
            ->toArray();

        $payslips = $Payslips->find()
            ->where(['Payslips.pay_period_id' => $payPeriodId, 'Payslips.company_id' => $companyId])
            ->contain(['PayslipItems', 'Employees'])
            ->all();

        \Cake\Log\Log::debug(sprintf('Posting payroll for period %d, found %d payslips', $payPeriodId, count($payslips)));

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $payslips, $salariesPayable, $payePayable, $nssaPayable,
            $earningAccounts, $deductionAccounts, $companyId, $date, $payPeriodId
        ) {
            foreach ($payslips as $payslip) {
                $groupId = Text::uuid();
                $ref = 'Payslip ' . $payslip->id . ' - ' . ($payslip->employee->first_name ?? '') . ' ' . ($payslip->employee->last_name ?? '');
                
                $hasTransactions = false;

                // Track net pay per currency
                $netPayUsd = 0;
                $netPayZwg = 0;

                foreach ($payslip->payslip_items as $item) {
                    $amount = (float)$item->amount;
                    if ($amount <= 0) continue;

                    $currency = $item->currency ?? 'USD';

                    if ($item->item_type === 'Earning') {
                        $accId = $earningAccounts[$item->name] ?? null;
                        if ($accId) {
                            $dr = $Transactions->newEntity([
                                'company_id'        => $companyId,
                                'date'              => $date,
                                'description'       => $ref . ' - ' . $item->name,
                                'currency'          => $currency,
                                'amount'            => $amount,
                                'type'              => 'Debit',
                                'account_id'        => $accId,
                                'payperiod_id'      => $payPeriodId,
                                'tenant_id'         => null,
                                'transaction_group' => $groupId,
                            ], ['validate' => false]);
                            if (!$Transactions->save($dr, ['check_balance' => false])) {
                                \Cake\Log\Log::error('Failed to save Earning transaction: ' . json_encode($dr->getErrors()));
                            } else {
                                $hasTransactions = true;
                            }

                            if ($currency === 'USD') $netPayUsd += $amount;
                            if ($currency === 'ZWG') $netPayZwg += $amount;
                        } else {
                            \Cake\Log\Log::warning(sprintf('No account found for earning item: %s', $item->name));
                        }
                    } elseif ($item->item_type === 'Deduction') {
                        $accId = $deductionAccounts[$item->name] ?? null;
                        if ($accId) {
                            $cr = $Transactions->newEntity([
                                'company_id'        => $companyId,
                                'date'              => $date,
                                'description'       => $ref . ' - ' . $item->name,
                                'currency'          => $currency,
                                'amount'            => $amount,
                                'type'              => 'Credit',
                                'account_id'        => $accId,
                                'payperiod_id'      => $payPeriodId,
                                'tenant_id'         => null,
                                'transaction_group' => $groupId,
                            ], ['validate' => false]);
                            if (!$Transactions->save($cr, ['check_balance' => false])) {
                                \Cake\Log\Log::error('Failed to save Deduction transaction: ' . json_encode($cr->getErrors()));
                            } else {
                                $hasTransactions = true;
                            }

                            if ($currency === 'USD') $netPayUsd -= $amount;
                            if ($currency === 'ZWG') $netPayZwg -= $amount;
                        } else {
                            \Cake\Log\Log::warning(sprintf('No account found for deduction item: %s', $item->name));
                        }
                    } elseif ($item->item_type === 'Tax') {
                        $accId = null;
                        if (stripos($item->name, 'PAYE') !== false) {
                            $accId = $payePayable ? $payePayable->id : null;
                        } elseif (stripos($item->name, 'NSSA') !== false) {
                            $accId = $nssaPayable ? $nssaPayable->id : null;
                        }
                        
                        if ($accId) {
                            $cr = $Transactions->newEntity([
                                'company_id'        => $companyId,
                                'date'              => $date,
                                'description'       => $ref . ' - ' . $item->name,
                                'currency'          => $currency,
                                'amount'            => $amount,
                                'type'              => 'Credit',
                                'account_id'        => $accId,
                                'payperiod_id'      => $payPeriodId,
                                'tenant_id'         => null,
                                'transaction_group' => $groupId,
                            ], ['validate' => false]);
                            if (!$Transactions->save($cr, ['check_balance' => false])) {
                                \Cake\Log\Log::error('Failed to save Tax transaction: ' . json_encode($cr->getErrors()));
                            } else {
                                $hasTransactions = true;
                            }

                            if ($currency === 'USD') $netPayUsd -= $amount;
                            if ($currency === 'ZWG') $netPayZwg -= $amount;
                        } else {
                            \Cake\Log\Log::warning(sprintf('No account found for tax item: %s', $item->name));
                        }
                    }
                }

                // Credit Net Pay
                if ($salariesPayable && $hasTransactions) {
                    if ($netPayUsd > 0) {
                        $crUsd = $Transactions->newEntity([
                            'company_id'        => $companyId,
                            'date'              => $date,
                            'description'       => $ref . ' - Net Pay (USD)',
                            'currency'          => 'USD',
                            'amount'            => $netPayUsd,
                            'type'              => 'Credit',
                            'account_id'        => $salariesPayable->id,
                            'payperiod_id'      => $payPeriodId,
                            'tenant_id'         => null,
                            'transaction_group' => $groupId,
                        ], ['validate' => false]);
                        if (!$Transactions->save($crUsd, ['check_balance' => false])) {
                            \Cake\Log\Log::error('Failed to save Net Pay USD transaction: ' . json_encode($crUsd->getErrors()));
                        }
                    }
                    
                    if ($netPayZwg > 0) {
                        $crZwg = $Transactions->newEntity([
                            'company_id'        => $companyId,
                            'date'              => $date,
                            'description'       => $ref . ' - Net Pay (ZWG)',
                            'currency'          => 'ZWG',
                            'amount'            => $netPayZwg,
                            'type'              => 'Credit',
                            'account_id'        => $salariesPayable->id,
                            'payperiod_id'      => $payPeriodId,
                            'tenant_id'         => null,
                            'transaction_group' => $groupId,
                        ], ['validate' => false]);
                        if (!$Transactions->save($crZwg, ['check_balance' => false])) {
                            \Cake\Log\Log::error('Failed to save Net Pay ZWG transaction: ' . json_encode($crZwg->getErrors()));
                        }
                    }
                }
            }
        });
    }
}
