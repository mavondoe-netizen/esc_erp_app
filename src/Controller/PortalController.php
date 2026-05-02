<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Portal Controller
 *
 * Employee Self-Service Portal — allows employees to view their own payslips,
 * apply for leave, and manage their profile without access to the main ERP.
 */
class PortalController extends AppController
{
    /**
     * Resolve the Employee record linked to the logged-in user.
     *
     * Returns null when the user has no employee_id set (e.g. admin accounts).
     *
     * @return \App\Model\Entity\Employee|null
     */
    private function _getEmployee()
    {
        $user = $this->Authentication->getIdentity();
        $employeeId = $user->get('employee_id');

        if (empty($employeeId)) {
            return null;
        }

        $companyId = $user->get('company_id');
        $Employees = TableRegistry::getTableLocator()->get('Employees');

        return $Employees->find()
            ->where(['Employees.id' => $employeeId, 'Employees.company_id' => $companyId])
            ->first();
    }

    /**
     * Portal dashboard.
     *
     * @return void
     */
    public function dashboard()
    {
        $employee = $this->_getEmployee();

        $leaveBalances = [];
        $recentPayslips = [];

        if ($employee) {
            $LeaveBalances = TableRegistry::getTableLocator()->get('LeaveBalances');
            $leaveBalances = $LeaveBalances->find()
                ->where(['LeaveBalances.employee_id' => $employee->id])
                ->contain(['LeaveTypes'])
                ->all();

            $Payslips = TableRegistry::getTableLocator()->get('Payslips');
            $recentPayslips = $Payslips->find()
                ->where(['Payslips.employee_id' => $employee->id])
                ->order(['Payslips.pay_date' => 'DESC'])
                ->limit(6)
                ->all();
        }

        $this->set(compact('employee', 'leaveBalances', 'recentPayslips'));
    }

    /**
     * View employee's payslips.
     *
     * @return void
     */
    public function payslips()
    {
        $employee = $this->_getEmployee();

        $payslips = [];
        if ($employee) {
            $Payslips = TableRegistry::getTableLocator()->get('Payslips');
            $payslips = $Payslips->find()
                ->where(['Payslips.employee_id' => $employee->id])
                ->order(['Payslips.pay_date' => 'DESC'])
                ->all();
        }

        $this->set(compact('payslips', 'employee'));
    }

    /**
     * View a single payslip.
     *
     * @param int $id Payslip ID.
     * @return void
     */
    public function payslipView(int $id)
    {
        $employee = $this->_getEmployee();

        if (!$employee) {
            throw new \Cake\Http\Exception\NotFoundException('Employee not found.');
        }

        $Payslips = TableRegistry::getTableLocator()->get('Payslips');
        $payslip = $Payslips->get($id, contain: ['Employees', 'PayPeriods']);

        if ((int)$payslip->employee_id !== (int)$employee->id) {
            throw new \Cake\Http\Exception\ForbiddenException('Access denied.');
        }

        $this->set(compact('payslip', 'employee'));
    }

    /**
     * Apply for leave.
     *
     * @return \Cake\Http\Response|null
     */
    public function leaveApply()
    {
        $employee = $this->_getEmployee();

        if (!$employee) {
            $this->Flash->error('No employee profile found for your account.');
            return $this->redirect(['action' => 'dashboard']);
        }

        $LeaveApplications = TableRegistry::getTableLocator()->get('LeaveApplications');
        $leaveApplication = $LeaveApplications->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['employee_id'] = $employee->id;
            $leaveApplication = $LeaveApplications->patchEntity($leaveApplication, $data);

            if ($LeaveApplications->save($leaveApplication)) {
                $this->Flash->success('Leave application submitted successfully.');
                return $this->redirect(['action' => 'leaveHistory']);
            }
            $this->Flash->error('Could not submit leave application. Please check for errors.');
        }

        $user = $this->Authentication->getIdentity();
        $companyId = $user->get('company_id');
        $LeaveTypes = TableRegistry::getTableLocator()->get('LeaveTypes');
        $leaveTypes = $LeaveTypes->find('list', keyField: 'id', valueField: 'name')
            ->where(['LeaveTypes.company_id' => $companyId])
            ->all();

        $this->set(compact('leaveApplication', 'leaveTypes', 'employee'));
    }

    /**
     * Leave application history.
     *
     * @return void
     */
    public function leaveHistory()
    {
        $employee = $this->_getEmployee();

        $leaveApplications = [];
        if ($employee) {
            $LeaveApplications = TableRegistry::getTableLocator()->get('LeaveApplications');
            $leaveApplications = $LeaveApplications->find()
                ->where(['LeaveApplications.employee_id' => $employee->id])
                ->contain(['LeaveTypes'])
                ->order(['LeaveApplications.created' => 'DESC'])
                ->all();
        }

        $this->set(compact('leaveApplications', 'employee'));
    }

    /**
     * Leave balances.
     *
     * @return void
     */
    public function leaveBalances()
    {
        $employee = $this->_getEmployee();

        $leaveBalances = [];
        if ($employee) {
            $LeaveBalances = TableRegistry::getTableLocator()->get('LeaveBalances');
            $leaveBalances = $LeaveBalances->find()
                ->where(['LeaveBalances.employee_id' => $employee->id])
                ->contain(['LeaveTypes'])
                ->all();
        }

        $this->set(compact('leaveBalances', 'employee'));
    }

    /**
     * Employee profile.
     *
     * @return \Cake\Http\Response|null
     */
    public function profile()
    {
        $employee = $this->_getEmployee();

        $this->set(compact('employee'));
    }
}
