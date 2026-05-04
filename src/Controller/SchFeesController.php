<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchFees Controller
 */
class SchFeesController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $schFees = $this->paginate($this->SchFees->find()->contain(['SchStudents']));
        $this->set(compact('schFees'));
    }

    public function view($id = null)
    {
        $schFee = $this->SchFees->get($id, contain: ['SchStudents']);
        $this->set(compact('schFee'));
    }

    public function add()
    {
        $schFee = $this->SchFees->newEmptyEntity();
        if ($this->request->is('post')) {
            $schFee = $this->SchFees->patchEntity($schFee, $this->request->getData());
            if ($this->SchFees->save($schFee)) {
                $this->Flash->success(__('The fee record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fee record could not be saved. Please, try again.'));
        }
        $schStudents = $this->SchFees->SchStudents->find('list', limit: 200)->all();
        $this->set(compact('schFee', 'schStudents'));
    }

    public function edit($id = null)
    {
        $schFee = $this->SchFees->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $schFee = $this->SchFees->patchEntity($schFee, $this->request->getData());
            if ($this->SchFees->save($schFee)) {
                $this->Flash->success(__('The fee record has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fee record could not be saved. Please, try again.'));
        }
        $schStudents = $this->SchFees->SchStudents->find('list', limit: 200)->all();
        $this->set(compact('schFee', 'schStudents'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schFee = $this->SchFees->get($id);
        if ($this->SchFees->delete($schFee)) {
            $this->Flash->success(__('The fee record has been deleted.'));
        } else {
            $this->Flash->error(__('The fee record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
