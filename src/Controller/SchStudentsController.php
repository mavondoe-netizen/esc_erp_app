<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchStudents Controller
 */
class SchStudentsController extends AppController
{
    use \App\Controller\Traits\ImportExportTrait;

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $query = $this->SchStudents->find()->contain(['Users', 'SchClasses', 'Contacts']);

        // Parent Portal: Only show linked students
        if ((int)$user->get('role_id') === 6) {
            $query->where(['SchStudents.contact_id' => $user->get('id')]);
        }

        $schStudents = $this->paginate($query);
        $this->set(compact('schStudents'));
    }

    public function view($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $schStudent = $this->SchStudents->get($id, contain: [
            'Users',
            'SchClasses',
            'Contacts',
            'SchResults.SchSubjects',
            'SchAttendance',
            'Invoices.InvoiceItems',
            'Receipts',
        ]);

        // Parent Portal: Restrict access to only their children
        if ((int)$user->get('role_id') === 6 && (int)$schStudent->contact_id !== (int)$user->get('id')) {
            $this->Flash->error(__('You are not authorized to view this student profile.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('schStudent'));
    }

    public function add()
    {
        $schStudent = $this->SchStudents->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Quick Add Contact Logic
            if (empty($data['contact_id']) && !empty($data['guardian_name'])) {
                $contact = $this->SchStudents->Contacts->newEmptyEntity();
                $contact->name = $data['guardian_name'];
                $contact->mobile = $data['guardian_phone'] ?? 'N/A';
                $contact->email = 'pending' . time() . '@example.com';
                $contact->company_id = \Cake\Core\Configure::read('Tenant.company_id') ?? 1;
                
                if ($this->SchStudents->Contacts->save($contact)) {
                    $data['contact_id'] = $contact->id;
                }
            }

            // Admission Logic: If no user_id, we can create a placeholder user or ask to select one
            $schStudent = $this->SchStudents->patchEntity($schStudent, $data);
            if ($this->SchStudents->save($schStudent)) {
                $this->Flash->success(__('The student has been admitted.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be admitted. Please, try again.'));
        }
        $users = $this->SchStudents->Users->find('list', limit: 200)->all();
        $schClasses = $this->SchStudents->SchClasses->find('list', limit: 200)->all();
        $contacts = $this->SchStudents->Contacts->find('list', limit: 200)->all();
        $this->set(compact('schStudent', 'users', 'schClasses', 'contacts'));
    }

    public function edit($id = null)
    {
        $schStudent = $this->SchStudents->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Quick Add Contact Logic
            if (empty($data['contact_id']) && !empty($data['guardian_name'])) {
                $contact = $this->SchStudents->Contacts->newEmptyEntity();
                $contact->name = $data['guardian_name'];
                $contact->mobile = $data['guardian_phone'] ?? 'N/A';
                $contact->email = 'pending' . time() . '@example.com';
                $contact->company_id = \Cake\Core\Configure::read('Tenant.company_id') ?? 1;
                
                if ($this->SchStudents->Contacts->save($contact)) {
                    $data['contact_id'] = $contact->id;
                }
            }

            $schStudent = $this->SchStudents->patchEntity($schStudent, $data);
            if ($this->SchStudents->save($schStudent)) {
                $this->Flash->success(__('The student record has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student record could not be updated. Please, try again.'));
        }
        $users = $this->SchStudents->Users->find('list', limit: 200)->all();
        $schClasses = $this->SchStudents->SchClasses->find('list', limit: 200)->all();
        $contacts = $this->SchStudents->Contacts->find('list', limit: 200)->all();
        $this->set(compact('schStudent', 'users', 'schClasses', 'contacts'));
    }

    public function reportCard($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $this->viewBuilder()->setLayout('document');
        $schStudent = $this->SchStudents->get($id, contain: [
            'Users', 
            'SchClasses', 
            'Contacts',
            'SchResults.SchSubjects', 
            'SchResults.SchExams'
        ]);

        // Parent Portal: Restrict access
        if ((int)$user->get('role_id') === 6 && (int)$schStudent->contact_id !== (int)$user->get('id')) {
            $this->Flash->error(__('You are not authorized to view this report card.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $company = $this->fetchTable('Companies')->get($companyId);
        
        $this->set(compact('schStudent', 'company'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $schStudent = $this->SchStudents->get($id);
        if ($this->SchStudents->delete($schStudent)) {
            $this->Flash->success(__('The student record has been deleted.'));
        } else {
            $this->Flash->error(__('The student record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
