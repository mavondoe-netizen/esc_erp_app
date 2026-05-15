<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchExams Controller
 */
class SchExamsController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schExams = $this->paginate($this->SchExams->find()->contain(['SchSubjects']));
        $this->set(compact('schExams'));
    }

    public function view($id = null)
    {
        $schExam = $this->SchExams->get($id, contain: ['SchSubjects', 'SchResults.SchStudents', 'SchResults.SchSubjects']);
        $this->set(compact('schExam'));
    }

    public function add()
    {
        $schExam = $this->SchExams->newEmptyEntity();
        if ($this->request->is('post')) {
            $schExam = $this->SchExams->patchEntity($schExam, $this->request->getData());
            if ($this->SchExams->save($schExam)) {
                $this->Flash->success(__('The exam has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exam could not be saved. Please, try again.'));
        }
        $schSubjects = $this->fetchTable('SchSubjects')->find('list')->all();
        $this->set(compact('schExam', 'schSubjects'));
    }

    public function edit($id = null)
    {
        $schExam = $this->SchExams->get($id, contain: ['SchSubjects']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schExam = $this->SchExams->patchEntity($schExam, $this->request->getData());
            if ($this->SchExams->save($schExam)) {
                $this->Flash->success(__('The exam record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exam could not be updated. Please, try again.'));
        }
        $schSubjects = $this->fetchTable('SchSubjects')->find('list')->all();
        $this->set(compact('schExam', 'schSubjects'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schExam = $this->SchExams->get($id);
        if ($this->SchExams->delete($schExam)) {
            $this->Flash->success(__('The exam record has been deleted.'));
        } else {
            $this->Flash->error(__('The exam could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
