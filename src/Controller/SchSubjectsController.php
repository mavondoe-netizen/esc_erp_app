<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchSubjects Controller
 */
class SchSubjectsController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schSubjects = $this->paginate($this->SchSubjects->find()->contain(['SchClasses']));
        $this->set(compact('schSubjects'));
    }

    public function view($id = null)
    {
        $schSubject = $this->SchSubjects->get($id, contain: ['SchClasses']);
        $this->set(compact('schSubject'));
    }

    public function add()
    {
        $schSubject = $this->SchSubjects->newEmptyEntity();
        if ($this->request->is('post')) {
            $schSubject = $this->SchSubjects->patchEntity($schSubject, $this->request->getData());
            if ($this->SchSubjects->save($schSubject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be saved. Please, try again.'));
        }
        $schClasses = $this->SchSubjects->SchClasses->find('list', limit: 200)->all();
        $this->set(compact('schSubject', 'schClasses'));
    }

    public function edit($id = null)
    {
        $schSubject = $this->SchSubjects->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schSubject = $this->SchSubjects->patchEntity($schSubject, $this->request->getData());
            if ($this->SchSubjects->save($schSubject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be saved. Please, try again.'));
        }
        $schClasses = $this->SchSubjects->SchClasses->find('list', limit: 200)->all();
        $this->set(compact('schSubject', 'schClasses'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schSubject = $this->SchSubjects->get($id);
        if ($this->SchSubjects->delete($schSubject)) {
            $this->Flash->success(__('The subject has been deleted.'));
        } else {
            $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
