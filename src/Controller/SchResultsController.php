<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchResults Controller
 */
class SchResultsController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schResults = $this->paginate($this->SchResults->find()->contain(['SchStudents', 'SchSubjects', 'SchExams']));
        $this->set(compact('schResults'));
    }

    public function add()
    {
        $schResult = $this->SchResults->newEmptyEntity();
        if ($this->request->is('post')) {
            $schResult = $this->SchResults->patchEntity($schResult, $this->request->getData());
            if ($this->SchResults->save($schResult)) {
                $this->Flash->success(__('The marks have been recorded.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The marks could not be saved. Please, try again.'));
        }
        $schStudents = $this->SchResults->SchStudents->find('list', limit: 200)->all();
        $schSubjects = $this->SchResults->SchSubjects->find('list', limit: 200)->all();
        $schExams = $this->SchResults->SchExams->find('list', limit: 200)->all();
        $this->set(compact('schResult', 'schStudents', 'schSubjects', 'schExams'));
    }

    public function edit($id = null)
    {
        $schResult = $this->SchResults->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schResult = $this->SchResults->patchEntity($schResult, $this->request->getData());
            if ($this->SchResults->save($schResult)) {
                $this->Flash->success(__('The record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The record could not be updated. Please, try again.'));
        }
        $schStudents = $this->SchResults->SchStudents->find('list', limit: 200)->all();
        $schSubjects = $this->SchResults->SchSubjects->find('list', limit: 200)->all();
        $schExams = $this->SchResults->SchExams->find('list', limit: 200)->all();
        $this->set(compact('schResult', 'schStudents', 'schSubjects', 'schExams'));
    }

    public function bulkAdd()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData('results');
            $entities = $this->SchResults->newEntities($data);
            if ($this->SchResults->saveMany($entities)) {
                $this->Flash->success(__('Bulk marks recorded.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not record marks in bulk.'));
        }
        
        $examId = $this->request->getQuery('exam_id');
        $classId = $this->request->getQuery('class_id');
        $subjectId = $this->request->getQuery('subject_id');
        
        $students = [];
        if ($classId) {
            $students = $this->fetchTable('SchStudents')->find()
                ->where(['class_id' => $classId])
                ->all();
        }
        
        $schClasses = $this->fetchTable('SchClasses')->find('list')->all();
        $schSubjects = $this->fetchTable('SchSubjects')->find('list')->all();
        $schExams = $this->fetchTable('SchExams')->find('list')->all();
        
        $this->set(compact('students', 'schClasses', 'schSubjects', 'schExams', 'examId', 'classId', 'subjectId'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schResult = $this->SchResults->get($id);
        if ($this->SchResults->delete($schResult)) {
            $this->Flash->success(__('The record has been deleted.'));
        } else {
            $this->Flash->error(__('The record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
