<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayPeriods Controller
 *
 * @property \App\Model\Table\PayPeriodsTable $PayPeriods
 */
class PayPeriodsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('PayPeriods')->find()
            ->contain(['Payslips']);
        //$query = $this->PayPeriods->find();
        $payPeriods = $this->paginate($query);

        $this->set(compact('payPeriods'));
    }

    /**
     * View method
     *
     * @param string|null $id Pay Period id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payPeriod = $this->fetchTable('PayPeriods')->get($id, contain: ['Payslips']);
        $this->set(compact('payPeriod'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payPeriod = $this->fetchTable('PayPeriods')->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if (!empty($data['month']) && !empty($data['year'])) {
                $month = str_pad((string)$data['month'], 2, '0', STR_PAD_LEFT);
                $year = $data['year'];
                $data['start_date'] = "$year-$month-01";
                $data['end_date'] = date("Y-m-t", strtotime($data['start_date']));
                $monthName = date("F", strtotime($data['start_date']));
                $data['name'] = "$monthName $year";
            }

            $payPeriod = $this->fetchTable('PayPeriods')->patchEntity($payPeriod, $data);
            if ($this->fetchTable('PayPeriods')->save($payPeriod)) {
                
                if ($payPeriod->status === 'Current') {
                    $this->fetchTable('PayPeriods')->updateAll(
                        ['status' => 'Previous'],
                        ['id !=' => $payPeriod->id]
                    );
                }

                $this->Flash->success(__('The pay period has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pay period could not be saved. Please, try again.'));
        }
        $this->set(compact('payPeriod'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pay Period id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payPeriod = $this->fetchTable('PayPeriods')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            if (!empty($data['month']) && !empty($data['year'])) {
                $month = str_pad((string)$data['month'], 2, '0', STR_PAD_LEFT);
                $year = $data['year'];
                $data['start_date'] = "$year-$month-01";
                $data['end_date'] = date("Y-m-t", strtotime($data['start_date']));
                $monthName = date("F", strtotime($data['start_date']));
                $data['name'] = "$monthName $year";
            }

            $payPeriod = $this->fetchTable('PayPeriods')->patchEntity($payPeriod, $data);
            if ($this->fetchTable('PayPeriods')->save($payPeriod)) {

                if ($payPeriod->status === 'Current') {
                    $this->fetchTable('PayPeriods')->updateAll(
                        ['status' => 'Previous'],
                        ['id !=' => $payPeriod->id]
                    );
                }

                $this->Flash->success(__('The pay period has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pay period could not be saved. Please, try again.'));
        }
        $this->set(compact('payPeriod'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pay Period id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payPeriod = $this->fetchTable('PayPeriods')->get($id);
        if ($this->fetchTable('PayPeriods')->delete($payPeriod)) {
            $this->Flash->success(__('The pay period has been deleted.'));
        } else {
            $this->Flash->error(__('The pay period could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Rollover method
     *
     * Closes the active 'Current' pay period and generates the next chronological calendar month.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function rollover()
    {
        $this->request->allowMethod(['post']);
        
        $currentPeriod = $this->fetchTable('PayPeriods')->find()->where(['status' => 'Current'])->first();
        
        if (!$currentPeriod) {
            $this->Flash->error(__('No active "Current" Pay Period found to rollover.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Lock the current period
        $currentPeriod->set('status', 'Previous');
        $this->fetchTable('PayPeriods')->save($currentPeriod);
        
        // Compute the next month safely via DateTime
        $dateObj = new \DateTime($currentPeriod->start_date->format('Y-m-d'));
        $dateObj->modify('+1 month');
        
        $newMonthStr = $dateObj->format('F Y'); // e.g., "May 2026"
        $newStart = new \DateTime('first day of ' . $newMonthStr);
        $newEnd = new \DateTime('last day of ' . $newMonthStr);
        
        // Instantiate the new active rollover period
        $newPeriod = $this->fetchTable('PayPeriods')->newEmptyEntity();
        $newPeriod->name = $newMonthStr;
        $newPeriod->start_date = $newStart;
        $newPeriod->end_date = $newEnd;
        $newPeriod->status = 'Current';
        $newPeriod->company_id = $currentPeriod->company_id;
        
        if ($this->fetchTable('PayPeriods')->save($newPeriod)) {
            $this->Flash->success(__('Payroll successfully rolled over to {0}. Previous period locked.', $newMonthStr));
        } else {
            $this->Flash->error(__('Failed to construct the next rollover period. Please verify configurations.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
}
