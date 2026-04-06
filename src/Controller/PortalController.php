<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Portal Controller
 * 
 * Employee Self-Service Portal — employees access their own data only.
 * Only accessible to users with the 'Employee' role.
 */
class PortalController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Only 'Employee' role users may access the portal
        try {
            $role = $this->fetchTable('Roles')->get($identity->role_id);
            if (strtolower($role->name) !== 'employee') {
                // Admins can also view their own portal if they have an employee_id
                if (!$identity->employee_id) {
                    $this->Flash->error('The Employee Portal is only accessible to employees.');
                    return $this->redirect('/');
                }
            }
        } catch (\Exception $e) {
            return $this->redirect('/');
        }
    }

    /**
     * Dashboard — overview of leave balance, latest payslip, pending applications
     */
    public function dashboard()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $employee = $this->fetchTable('Employees')->get($employeeId, contain: ['EmployeeProfiles']);

        // Latest payslip
        $latestPayslip = $this->fetchTable('Payslips')->find()
            ->where(['employee_id' => $employeeId])
            ->contain(['PayPeriods'])
            ->order(['generated_date' => 'DESC'])
            ->first();

        // Leave balances this year
        $year = (int)date('Y');
        $leaveBalances = $this->fetchTable('LeaveBalances')->find()
            ->where(['employee_id' => $employeeId, 'year' => $year])
            ->contain(['LeaveTypes'])
            ->all();

        // Pending leave applications
        $pendingLeave = $this->fetchTable('LeaveApplications')->find()
            ->where(['employee_id' => $employeeId, 'status' => 'Pending'])
            ->order(['created' => 'DESC'])
            ->all();

        $this->set(compact('employee', 'latestPayslip', 'leaveBalances', 'pendingLeave'));
    }

    /**
     * Payslips — employee's own payslips only
     */
    public function payslips()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $payslips = $this->fetchTable('Payslips')->find()
            ->where(['employee_id' => $employeeId])
            ->contain(['PayPeriods'])
            ->order(['generated_date' => 'DESC'])
            ->all();

        $this->set(compact('payslips'));
    }

    /**
     * Payslip View — validates payslip belongs to the logged-in employee
     */
    public function payslipView($id = null)
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $payslip = $this->fetchTable('Payslips')->find()
            ->where(['id' => $id, 'employee_id' => $employeeId])
            ->contain(['Employees', 'PayPeriods', 'PayslipItems'])
            ->first();

        if (!$payslip) {
            $this->Flash->error('Payslip not found or you do not have access to it.');
            return $this->redirect(['action' => 'payslips']);
        }

        $year = (int)$payslip->generated_date->format('Y');
        $leaveBalances = $this->fetchTable('LeaveBalances')->find()
            ->where(['employee_id' => $employeeId, 'year' => $year])
            ->contain(['LeaveTypes'])
            ->all();

        // Get company for branding
        $companyId = $identity->company_id;
        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('payslip', 'leaveBalances', 'company'));
    }

    /**
     * Leave Apply — pre-fills employee_id, prevents manipulation
     */
    public function leaveApply()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $leaveApplication = $this->fetchTable('LeaveApplications')->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Force employee_id from session — cannot be overridden
            $data['employee_id'] = $employeeId;
            $data['status'] = 'Pending';

            // Calculate days_requested
            if (!empty($data['start_date']) && !empty($data['end_date'])) {
                $start = new \DateTime($data['start_date']);
                $end = new \DateTime($data['end_date']);
                $data['days_requested'] = max(1, (int)$start->diff($end)->days + 1);
            }

            $leaveApplication = $this->fetchTable('LeaveApplications')->patchEntity($leaveApplication, $data);
            if ($this->fetchTable('LeaveApplications')->save($leaveApplication)) {
                $this->Flash->success('Your leave application has been submitted successfully.');
                return $this->redirect(['action' => 'leaveHistory']);
            }
            $this->Flash->error('Could not submit application. Please check your input.');
        }

        $leaveTypes = $this->fetchTable('LeaveTypes')->find('list')->all();

        // Current balances for display
        $year = (int)date('Y');
        $leaveBalances = $this->fetchTable('LeaveBalances')->find()
            ->where(['employee_id' => $employeeId, 'year' => $year])
            ->contain(['LeaveTypes'])
            ->all();

        $this->set(compact('leaveApplication', 'leaveTypes', 'leaveBalances'));
    }

    /**
     * Leave History — employee's own applications
     */
    public function leaveHistory()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $applications = $this->fetchTable('LeaveApplications')->find()
            ->where(['employee_id' => $employeeId])
            ->contain(['LeaveTypes'])
            ->order(['created' => 'DESC'])
            ->all();

        $this->set(compact('applications'));
    }

    /**
     * Leave Balances — current balance summary
     */
    public function leaveBalances()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $year = (int)date('Y');
        $leaveBalances = $this->fetchTable('LeaveBalances')->find()
            ->where(['employee_id' => $employeeId, 'year' => $year])
            ->contain(['LeaveTypes'])
            ->all();

        $this->set(compact('leaveBalances', 'year'));
    }

    /**
     * Profile — view own employee record
     */
    public function profile()
    {
        $this->viewBuilder()->setLayout('portal');
        $identity = $this->request->getAttribute('identity');
        $employeeId = $identity->employee_id;

        $employee = $this->fetchTable('Employees')->get($employeeId, contain: ['EmployeeProfiles']);

        $this->set(compact('employee'));
    }
}
