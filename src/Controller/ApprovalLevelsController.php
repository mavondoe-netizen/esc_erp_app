<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * ApprovalLevels Controller
 *
 * CRUD for approval workflow levels/stages.
 */
class ApprovalLevelsController extends AppController
{
    /**
     * Index — list all approval levels.
     *
     * @return void
     */
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $ApprovalLevels = TableRegistry::getTableLocator()->get('ApprovalLevels');
        $query = $ApprovalLevels->find()
            ->where(['ApprovalLevels.company_id' => $companyId])
            ->contain(['ApprovalFlows'])
            ->all();

        $this->set('approvalLevels', $query);
    }

    /**
     * View a single approval level.
     *
     * @param int $id ApprovalLevel ID.
     * @return void
     */
    public function view(int $id)
    {
        $ApprovalLevels = TableRegistry::getTableLocator()->get('ApprovalLevels');
        $approvalLevel = $ApprovalLevels->get($id, contain: ['ApprovalFlows']);
        $this->set(compact('approvalLevel'));
    }

    /**
     * Add a new approval level.
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $ApprovalLevels = TableRegistry::getTableLocator()->get('ApprovalLevels');
        $approvalLevel = $ApprovalLevels->newEmptyEntity();

        if ($this->request->is('post')) {
            $companyId = $this->request->getAttribute('company_id');
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $approvalLevel = $ApprovalLevels->patchEntity($approvalLevel, $data);

            if ($this->request->getQuery('popup')) {
                $this->set('popupResult', [
                    'id' => $approvalLevel->id ?? 0,
                    'name' => $approvalLevel->name ?? 'New Level',
                ]);
                $this->viewBuilder()->disableAutoLayout();
                return $this->render('/Element/popup_success');
            }

            if ($ApprovalLevels->save($approvalLevel)) {
                $this->Flash->success(__('The approval level has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval level could not be saved. Please, try again.'));
        }

        $companyId = $this->request->getAttribute('company_id');
        $ApprovalFlows = TableRegistry::getTableLocator()->get('ApprovalFlows');
        $approvalFlows = $ApprovalFlows->find('list', keyField: 'id', valueField: 'name')
            ->where(['ApprovalFlows.company_id' => $companyId])
            ->all();

        $this->set(compact('approvalLevel', 'approvalFlows'));
    }

    /**
     * Edit an approval level.
     *
     * @param int $id ApprovalLevel ID.
     * @return \Cake\Http\Response|null
     */
    public function edit(int $id)
    {
        $ApprovalLevels = TableRegistry::getTableLocator()->get('ApprovalLevels');
        $approvalLevel = $ApprovalLevels->get($id);

        if ($this->request->is(['post', 'put'])) {
            $approvalLevel = $ApprovalLevels->patchEntity($approvalLevel, $this->request->getData());
            if ($ApprovalLevels->save($approvalLevel)) {
                $this->Flash->success(__('The approval level has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval level could not be saved. Please, try again.'));
        }

        $companyId = $this->request->getAttribute('company_id');
        $ApprovalFlows = TableRegistry::getTableLocator()->get('ApprovalFlows');
        $approvalFlows = $ApprovalFlows->find('list', keyField: 'id', valueField: 'name')
            ->where(['ApprovalFlows.company_id' => $companyId])
            ->all();

        $this->set(compact('approvalLevel', 'approvalFlows'));
    }

    /**
     * Delete an approval level.
     *
     * @param int $id ApprovalLevel ID.
     * @return \Cake\Http\Response|null
     */
    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ApprovalLevels = TableRegistry::getTableLocator()->get('ApprovalLevels');
        $approvalLevel = $ApprovalLevels->get($id);
        if ($ApprovalLevels->delete($approvalLevel)) {
            $this->Flash->success(__('The approval level has been deleted.'));
        } else {
            $this->Flash->error(__('The approval level could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
