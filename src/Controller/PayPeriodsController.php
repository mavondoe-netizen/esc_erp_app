<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;

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
            'Payslips' => ['Employees']
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
            $payPeriod = $this->PayPeriods->patchEntity($payPeriod, $this->request->getData());
            
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
            $payPeriod = $this->PayPeriods->patchEntity($payPeriod, $this->request->getData());
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
            ->where(['company_id' => $companyId])
            ->order(['end_date' => 'DESC'])
            ->first();

        if (!$latest) {
            $startDate = new FrozenDate('first day of this month');
            $endDate = new FrozenDate('last day of this month');
        } else {
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

        $this->Flash->error(__('Could not rollover to next month.'));
        return $this->redirect(['action' => 'index']);
    }
}
