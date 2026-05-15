<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchTeachers Controller
 */
class SchTeachersController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schTeachers = $this->paginate(
            $this->SchTeachers->find()->contain(['Users', 'Employees'])
        );
        $this->set(compact('schTeachers'));
    }

    public function view($id = null)
    {
        $schTeacher = $this->SchTeachers->get($id, contain: ['Users', 'Employees']);
        $this->set(compact('schTeacher'));
    }

    public function add()
    {
        $schTeacher = $this->SchTeachers->newEmptyEntity();
        if ($this->request->is('post')) {
            $schTeacher = $this->SchTeachers->patchEntity($schTeacher, $this->request->getData());
            if ($this->SchTeachers->save($schTeacher)) {
                $this->Flash->success(__('The teacher record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The teacher record could not be saved. Please, try again.'));
        }
        $companyId = $this->request->getAttribute('company_id');
        $users = $this->SchTeachers->Users->find('list', limit: 200)->all();
        [$employees, $employeesJson] = $this->_buildEmployeeList($companyId);
        $this->set(compact('schTeacher', 'users', 'employees', 'employeesJson'));
    }

    public function edit($id = null)
    {
        $schTeacher = $this->SchTeachers->get($id, contain: ['Employees']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schTeacher = $this->SchTeachers->patchEntity($schTeacher, $this->request->getData());
            if ($this->SchTeachers->save($schTeacher)) {
                $this->Flash->success(__('The teacher record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The teacher record could not be saved. Please, try again.'));
        }
        $companyId = $this->request->getAttribute('company_id');
        $users = $this->SchTeachers->Users->find('list', limit: 200)->all();
        [$employees, $employeesJson] = $this->_buildEmployeeList($companyId);
        $this->set(compact('schTeacher', 'users', 'employees', 'employeesJson'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schTeacher = $this->SchTeachers->get($id);
        if ($this->SchTeachers->delete($schTeacher)) {
            $this->Flash->success(__('The teacher record has been deleted.'));
        } else {
            $this->Flash->error(__('The teacher record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Returns [$dropdownLabels, $jsonMap] for the employee selector.
     * $jsonMap is a JSON-encoded object: { id: { employee_no, name } }
     */
    private function _buildEmployeeList(int $companyId): array
    {
        $labels = [];
        $json   = [];
        $list = $this->fetchTable('Employees')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'employee_code'])
            ->where(['Employees.company_id' => $companyId])
            ->orderBy(['Employees.first_name' => 'ASC'])
            ->all();
        foreach ($list as $emp) {
            $labels[$emp->id] = $emp->first_name . ' ' . $emp->last_name . ' (' . $emp->employee_code . ')';
            $json[$emp->id]   = [
                'employee_no' => $emp->employee_code,
                'name'        => $emp->first_name . ' ' . $emp->last_name,
            ];
        }
        return [$labels, json_encode($json)];
    }
}
