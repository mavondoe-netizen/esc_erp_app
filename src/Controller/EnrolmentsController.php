<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Enrolments Controller (Lease lifecycle: enrol, manage, terminate)
 *
 * @property \App\Model\Table\EnrolmentsTable $Enrolments
 */
class EnrolmentsController extends AppController
{
    public function index()
    {
        $query = $this->fetchTable('Enrolments')->find()
            ->contain(['Units' => ['Buildings'], 'Tenants'])
            ->order(['status' => 'ASC', 'start_date' => 'DESC']);
        $enrolments = $this->paginate($query);
        $this->set(compact('enrolments'));
    }

    public function view($id = null)
    {
        $enrolment = $this->fetchTable('Enrolments')->get($id, contain: [
            'Units' => ['Buildings'],
            'Tenants',
        ]);

        // Related payments and levies for this lease
        $payments = $this->fetchTable('LeasePayments')->find()
            ->where(['enrolment_id' => $id])
            ->order(['date' => 'DESC'])
            ->all();

        $levies = $this->fetchTable('Levies')->find()
            ->where(['enrolment_id' => $id])
            ->order(['due_date' => 'DESC'])
            ->all();

        $this->set(compact('enrolment', 'payments', 'levies'));
    }

    public function add()
    {
        $enrolment = $this->fetchTable('Enrolments')->newEmptyEntity();
        $enrolment->status = 'Active';
        $enrolment->start_date = date('Y-m-d');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $enrolment = $this->fetchTable('Enrolments')->patchEntity($enrolment, $data);

            // Double-booking guard — check that unit is not already actively leased
            $unitId = $enrolment->unit_id ?? null;
            if ($unitId) {
                $existingActive = $this->fetchTable('Enrolments')->find()
                    ->where(['unit_id' => $unitId, 'status' => 'Active'])
                    ->first();
                if ($existingActive) {
                    $this->Flash->error(__('This unit already has an active lease. Please terminate the existing lease first.'));
                    goto render;
                }
            }

            if ($this->fetchTable('Enrolments')->save($enrolment)) {
                $this->Flash->success(__('Lease enrolment created successfully.'));
                return $this->redirect(['action' => 'view', $enrolment->id]);
            }
            $this->Flash->error(__('The enrolment could not be saved. Please try again.'));
        }

        render:
        $units   = $this->fetchTable('Units')->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Tenants')->find('list', limit: 200)->all();
        $this->set(compact('enrolment', 'units', 'tenants'));
    }

    public function edit($id = null)
    {
        $enrolment = $this->fetchTable('Enrolments')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enrolment = $this->fetchTable('Enrolments')->patchEntity($enrolment, $this->request->getData());
            if ($this->fetchTable('Enrolments')->save($enrolment)) {
                $this->Flash->success(__('The enrolment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enrolment could not be saved. Please, try again.'));
        }
        $units   = $this->fetchTable('Enrolments')->Units->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Enrolments')->Tenants->find('list', limit: 200)->all();
        $this->set(compact('enrolment', 'units', 'tenants'));
    }

    /**
     * Terminate a lease: sets status to 'Terminated', records end_date.
     */
    public function terminate($id = null)
    {
        $this->request->allowMethod(['post']);
        $enrolment = $this->fetchTable('Enrolments')->get($id);

        if ($enrolment->status !== 'Active') {
            $this->Flash->error(__('Only active leases can be terminated.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        $enrolment->status   = 'Terminated';
        $enrolment->end_date = date('Y-m-d');

        if ($this->fetchTable('Enrolments')->save($enrolment)) {
            $this->Flash->success(__('Lease terminated. End date set to today.'));
        } else {
            $this->Flash->error(__('Could not terminate the lease. Please try again.'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enrolment = $this->fetchTable('Enrolments')->get($id);
        if ($this->fetchTable('Enrolments')->delete($enrolment)) {
            $this->Flash->success(__('The enrolment has been deleted.'));
        } else {
            $this->Flash->error(__('The enrolment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
