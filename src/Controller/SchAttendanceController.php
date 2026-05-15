<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchAttendance Controller
 */
class SchAttendanceController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $conditions = [];

        $date   = $this->request->getQuery('date');
        $status = $this->request->getQuery('status');

        if ($date)   $conditions['SchAttendance.date']   = $date;
        if ($status) $conditions['SchAttendance.status'] = $status;

        $query = $this->SchAttendance->find()
            ->where($conditions)
            ->contain(['SchStudents' => ['SchClasses']])
            ->orderBy(['SchAttendance.date' => 'DESC', 'SchAttendance.id' => 'DESC']);

        $schAttendance = $this->paginate($query, ['limit' => 50]);
        $this->set(compact('schAttendance'));
    }

    public function mark()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData('attendance');
            $entities = $this->SchAttendance->newEntities($data);
            if ($this->SchAttendance->saveMany($entities)) {
                $this->Flash->success(__('Attendance marked successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not mark attendance.'));
        }
        
        $classId = $this->request->getQuery('class_id');
        $date = $this->request->getQuery('date', date('Y-m-d'));
        
        $students = [];
        if ($classId) {
            $students = $this->fetchTable('SchStudents')->find()
                ->where(['class_id' => $classId])
                ->all();
        }
        
        $schClasses = $this->fetchTable('SchClasses')->find('list')->all();
        $this->set(compact('students', 'schClasses', 'classId', 'date'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schAttendance = $this->SchAttendance->get($id);
        if ($this->SchAttendance->delete($schAttendance)) {
            $this->Flash->success(__('Attendance record deleted.'));
        } else {
            $this->Flash->error(__('Could not delete attendance record.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
