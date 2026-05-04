<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchClasses Controller
 */
class SchClassesController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schClasses = $this->paginate($this->SchClasses->find());
        $this->set(compact('schClasses'));
    }

    public function view($id = null)
    {
        $schClass = $this->SchClasses->get($id, contain: ['SchSubjects', 'SchStudents']);
        $this->set(compact('schClass'));
    }

    public function add()
    {
        $schClass = $this->SchClasses->newEmptyEntity();
        if ($this->request->is('post')) {
            $schClass = $this->SchClasses->patchEntity($schClass, $this->request->getData());
            if ($this->SchClasses->save($schClass)) {
                $this->Flash->success(__('The class has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The class could not be saved. Please, try again.'));
        }
        $this->set(compact('schClass'));
    }

    public function edit($id = null)
    {
        $schClass = $this->SchClasses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schClass = $this->SchClasses->patchEntity($schClass, $this->request->getData());
            if ($this->SchClasses->save($schClass)) {
                $this->Flash->success(__('The class has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The class could not be saved. Please, try again.'));
        }
        $this->set(compact('schClass'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schClass = $this->SchClasses->get($id);
        if ($this->SchClasses->delete($schClass)) {
            $this->Flash->success(__('The class has been deleted.'));
        } else {
            $this->Flash->error(__('The class could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
