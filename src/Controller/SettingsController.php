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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Settings are global parameters, just fetch the first record or create
        $setting = $this->Settings->find()->first();
        if (!$setting) {
            $setting = $this->Settings->newEmptyEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The statutory settings have been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The statutory settings could not be saved. Please check for errors.'));
        }

        $this->set(compact('setting'));
    }
}
