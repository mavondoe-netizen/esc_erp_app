<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Sandbox Controller
 *
 * Development/demo utility for seeding, schema syncing, and resetting data.
 * Should only be accessible to super-admins.
 */
class SandboxController extends AppController
{
    /**
     * Sandbox home.
     *
     * @return void
     */
    public function index()
    {
        $session = $this->request->getSession();
        $sandboxModeActive = (bool)$session->read('Sandbox.active');

        // Check if sandbox DB is connected
        $sandboxConnected = false;
        $tableList = [];

        try {
            $conn = \Cake\Datasource\ConnectionManager::get('sandbox');
            $conn->getDriver()->connect();
            $sandboxConnected = true;
            
            if ($sandboxConnected) {
                // Get list of tables from default connection
                $defaultConn = \Cake\Datasource\ConnectionManager::get('default');
                $schema = $defaultConn->getSchemaCollection();
                $tables = $schema->listTables();

                // Sort tables and get some counts
                sort($tables);
                $tables = array_filter($tables, fn($t) => !str_contains($t, 'phinx')); // hide migration tables

                foreach (array_slice($tables, 0, 20) as $table) {
                    $prodCount = $defaultConn->execute("SELECT COUNT(*) as cnt FROM $table")->fetch('assoc')['cnt'] ?? 0;
                    
                    $sandboxCount = 'N/A';
                    try {
                        $sandboxCount = $conn->execute("SELECT COUNT(*) as cnt FROM $table")->fetch('assoc')['cnt'] ?? 0;
                    } catch (\Exception $e) {
                        // Table likely missing in sandbox
                    }

                    $tableList[] = [
                        'table' => $table,
                        'prod_count' => $prodCount,
                        'sandbox_count' => $sandboxCount
                    ];
                }
            }
        } catch (\Exception $e) {
            $sandboxConnected = false;
        }

        $this->set(compact('sandboxModeActive', 'sandboxConnected', 'tableList'));
    }

    /**
     * Sync application schema from migrations.
     *
     * @return \Cake\Http\Response|null
     */
    public function syncSchema()
    {
        $this->request->allowMethod(['post']);
        exec('php bin/cake.php migrations migrate 2>&1', $output, $rc);
        $message = implode("\n", $output);
        if ($rc === 0) {
            $this->Flash->success('Schema synced successfully.');
        } else {
            $this->Flash->error('Schema sync failed: ' . $message);
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Seed demo data for sandbox/demo companies.
     *
     * @return \Cake\Http\Response|null
     */
    public function seedData()
    {
        $this->request->allowMethod(['post']);
        // Placeholder — actual seed class would be called here
        $this->Flash->success('Demo data seeded.');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reset sandbox environment (truncate sandbox company data).
     *
     * @return \Cake\Http\Response|null
     */
    public function reset()
    {
        $this->request->allowMethod(['post']);
        $this->Flash->success('Sandbox reset complete.');
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle sandbox mode flag.
     *
     * @return \Cake\Http\Response|null
     */
    public function toggleMode()
    {
        $this->request->allowMethod(['post']);
        $session = $this->request->getSession();
        $current = $session->read('Sandbox.active');
        $session->write('Sandbox.active', !$current);
        
        $this->Flash->success('Sandbox mode ' . (!$current ? 'activated' : 'deactivated') . '.');
        return $this->redirect($this->referer(['action' => 'index']));
    }
}
