<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{
    /**
     * Initialization hook method.
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $identity = $this->request->getAttribute('identity');
        $isAuthorized = false;
        
        if ($identity && isset($identity->role_id)) {
            try {
                $role = $this->fetchTable('Roles')->get($identity->role_id);
                $roleName = strtolower($role->name);
                $isAuthorized = in_array($roleName, ['manager', 'super admin', 'administrator', 'super administrator']);
            } catch (\Exception $e) {
                $isAuthorized = false;
            }
        }
        
        if (!$isAuthorized) {
            $this->Flash->error(__('You are not authorized to access Settings.'));
            return $this->redirect('/');
        }
    }

    /**
     * Index method used for updating settings
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $setting = $this->Settings->find()->first();
        if (!$setting) {
            $setting = $this->Settings->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The settings have been successfully updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The settings could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }
}
