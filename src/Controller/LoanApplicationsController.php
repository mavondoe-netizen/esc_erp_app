<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\Loans\LoanService;
use Cake\ORM\TableRegistry;

class LoanApplicationsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $query = $this->fetchTable('LoanApplications')
            ->find()
            ->contain(['LoanClients', 'LoanProducts'])
            ->order(['LoanApplications.created' => 'DESC']);
        $loanApplications = $this->paginate($query);
        $this->set(compact('loanApplications'));
    }

    public function view($id = null)
    {
        $app = $this->fetchTable('LoanApplications')->get($id, [
            'contain' => ['LoanClients', 'LoanProducts', 'LoanGuarantors'],
        ]);
        $this->set('application', $app);
    }

    public function add()
    {
        $application = $this->fetchTable('LoanApplications')->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['company_id'] = $this->request->getAttribute('identity')->company_id ?? null;
            $data['status'] = 'draft';
            $application = $this->fetchTable('LoanApplications')->patchEntity($application, $data);
            if ($this->fetchTable('LoanApplications')->save($application)) {
                $this->Flash->success('Application saved.');
                return $this->redirect(['action' => 'view', $application->id]);
            }
            $this->Flash->error('Could not save application.');
        }
        $clients  = $this->fetchTable('LoanClients')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $products = $this->fetchTable('LoanProducts')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $this->set(compact('application', 'clients', 'products'));
    }

    public function edit($id = null)
    {
        $app = $this->fetchTable('LoanApplications')->get($id);
        if (!in_array($app->status, ['draft'])) {
            $this->Flash->error('Only draft applications can be edited.');
            return $this->redirect(['action' => 'view', $id]);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $app = $this->fetchTable('LoanApplications')->patchEntity($app, $this->request->getData());
            if ($this->fetchTable('LoanApplications')->save($app)) {
                $this->Flash->success('Application updated.');
                return $this->redirect(['action' => 'view', $id]);
            }
        }
        $clients  = $this->fetchTable('LoanClients')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $products = $this->fetchTable('LoanProducts')->find('list', ['keyField' => 'id', 'valueField' => 'name'])->all();
        $application = $app;
        $this->set(compact('application', 'clients', 'products'));
    }

    /** Submits a draft application for review */
    public function submit($id = null)
    {
        $this->request->allowMethod(['post']);
        $app = $this->fetchTable('LoanApplications')->get($id);
        if ($app->status !== 'draft') {
            $this->Flash->error('Application is not in draft status.');
            return $this->redirect(['action' => 'view', $id]);
        }
        $app->status       = 'submitted';
        $app->submitted_at = date('Y-m-d H:i:s');
        $this->fetchTable('LoanApplications')->save($app);
        $this->Flash->success('Application submitted for review.');
        return $this->redirect(['action' => 'view', $id]);
    }

    /** Approves a submitted application and creates the loan account */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post']);
        $appsTable = $this->fetchTable('LoanApplications');
        $app = $appsTable->get($id, ['contain' => ['LoanClients', 'LoanProducts']]);

        if (!in_array($app->status, ['submitted', 'under_review'])) {
            $this->Flash->error('Application cannot be approved in its current status.');
            return $this->redirect(['action' => 'view', $id]);
        }

        $identity = $this->request->getAttribute('identity');
        $app->status      = 'approved';
        $app->decided_at  = date('Y-m-d H:i:s');
        $app->decided_by  = $identity->id ?? null;
        $appsTable->save($app);

        // Create the loan account automatically
        try {
            $loanService = new LoanService();
            $loan = $loanService->createFromApplication($app);
            $this->Flash->success("Application approved. Loan account {$loan->loan_account_no} created.");
            return $this->redirect(['controller' => 'Loans', 'action' => 'view', $loan->id]);
        } catch (\Exception $e) {
            $this->Flash->error('Approved but loan creation failed: ' . $e->getMessage());
            return $this->redirect(['action' => 'view', $id]);
        }
    }

    /** Rejects an application with a reason */
    public function reject($id = null)
    {
        $this->request->allowMethod(['post']);
        $app = $this->fetchTable('LoanApplications')->get($id);
        $reason = $this->request->getData('rejection_reason');
        $identity = $this->request->getAttribute('identity');

        $app->status           = 'rejected';
        $app->decided_at       = date('Y-m-d H:i:s');
        $app->decided_by       = $identity->id ?? null;
        $app->rejection_reason = $reason;
        $this->fetchTable('LoanApplications')->save($app);

        $this->Flash->success('Application rejected.');
        return $this->redirect(['action' => 'view', $id]);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $app = $this->fetchTable('LoanApplications')->get($id);
        if ($app->status !== 'draft') {
            $this->Flash->error('Only draft applications can be deleted.');
            return $this->redirect(['action' => 'index']);
        }
        if ($this->fetchTable('LoanApplications')->delete($app)) {
            $this->Flash->success('Application deleted.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
