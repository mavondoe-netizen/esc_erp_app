<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Event\EventInterface;
use Cake\Utility\Inflector;

/**
 * Sandbox Controller
 *
 * Super-Admin only environment for safely testing new features
 * against a separate sandbox database.
 */
class SandboxController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $identity = $this->request->getAttribute('identity');
        $isAuthorized = false;

        if ($identity && isset($identity->role_id)) {
            try {
                $role = $this->fetchTable('Roles')->get($identity->role_id);
                $roleName = strtolower($role->name);
                $isAuthorized = in_array($roleName, ['super admin', 'administrator', 'super administrator', 'manager']);
            } catch (\Exception $e) {
                $isAuthorized = false;
            }
        }

        if (!$isAuthorized) {
            $this->Flash->error('The Sandbox is restricted to Super Administrators only.');
            return $this->redirect('/');
        }
    }

    /**
     * Dashboard: compare production vs sandbox table row counts
     */
    public function index()
    {
        $prodConn = ConnectionManager::get('default');
        $tableList = [];

        try {
            $sandboxConn = ConnectionManager::get('sandbox');
            $prodTables = $prodConn->getSchemaCollection()->listTables();

            foreach ($prodTables as $table) {
                if (in_array($table, ['phinxlog'])) continue;
                $prodCount = $prodConn->execute("SELECT COUNT(*) as cnt FROM `$table`")->fetch('assoc')['cnt'] ?? 0;

                // Try sandbox count
                $sandboxCount = 0;
                try {
                    $sandboxCount = $sandboxConn->execute("SELECT COUNT(*) as cnt FROM `$table`")->fetch('assoc')['cnt'] ?? 0;
                } catch (\Exception $e) {
                    $sandboxCount = 'N/A';
                }

                $tableList[] = [
                    'table' => $table,
                    'prod_count' => $prodCount,
                    'sandbox_count' => $sandboxCount,
                ];
            }
            $sandboxConnected = true;
        } catch (\Exception $e) {
            $sandboxConnected = false;
        }

        $sandboxModeActive = $this->request->getSession()->read('Sandbox.active', false);

        $this->set(compact('tableList', 'sandboxConnected', 'sandboxModeActive'));
    }

    /**
     * Sync Schema — copies production DDL (structure only) to sandbox DB
     */
    public function syncSchema()
    {
        $this->request->allowMethod(['post']);

        try {
            $prodConn = ConnectionManager::get('default');
            $sandboxConn = ConnectionManager::get('sandbox');

            $prodTables = $prodConn->getSchemaCollection()->listTables();
            $synced = 0;
            $errors = [];

            foreach ($prodTables as $table) {
                if (in_array($table, ['phinxlog'])) continue;

                try {
                    // Get CREATE TABLE statement from production
                    $createRow = $prodConn->execute("SHOW CREATE TABLE `$table`")->fetch('assoc');
                    $createSql = $createRow['Create Table'] ?? null;

                    if ($createSql) {
                        // Drop & recreate in sandbox
                        $sandboxConn->execute("DROP TABLE IF EXISTS `$table`");
                        $sandboxConn->execute($createSql);
                        $synced++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "$table: " . $e->getMessage();
                }
            }

            if (empty($errors)) {
                $this->Flash->success("Schema sync complete: $synced tables copied to sandbox.");
            } else {
                $this->Flash->warning("Synced $synced tables with " . count($errors) . " errors: " . implode('; ', array_slice($errors, 0, 3)));
            }
        } catch (\Exception $e) {
            $this->Flash->error('Sync failed: ' . $e->getMessage());
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Seed Data — inserts realistic fake records into sandbox
     */
    public function seedData()
    {
        $this->request->allowMethod(['post']);

        try {
            $sandboxConn = ConnectionManager::get('sandbox');

            // Seed Company
            $sandboxConn->execute("INSERT IGNORE INTO `companies` (id, name, email, reporting_currency) VALUES (1, 'Sandbox Corp (Test)', 'test@sandbox.local', 'USD')");

            // Seed Roles
            $sandboxConn->execute("INSERT IGNORE INTO `roles` (id, name) VALUES (1,'User'),(2,'Approver'),(3,'Admin'),(4,'Manager'),(10,'Employee')");

            // Seed Accounts
            $sandboxConn->execute("INSERT IGNORE INTO `accounts` (id, company_id, name, category, subcategory, balance) VALUES
                (1, 1, 'Accounts Receivable', 1, 'Current Assets', 0),
                (2, 1, 'Revenue', 4, 'Sales', 0),
                (3, 1, 'Operating Expenses', 6, 'General', 0)
            ");

            // Seed test employees
            for ($i = 1; $i <= 5; $i++) {
                $sandboxConn->execute("INSERT IGNORE INTO `employees` (id, company_id, first_name, last_name, employee_code, email, basic_salary) VALUES
                    ($i, 1, 'Test$i', 'Employee', 'EMP00$i', 'emp$i@sandbox.local', " . (800 + ($i * 200)) . ")");
            }

            // Seed pay periods
            $sandboxConn->execute("INSERT IGNORE INTO `pay_periods` (id, company_id, name, start_date, end_date) VALUES
                (1, 1, 'Jan 2026', '2026-01-01', '2026-01-31'),
                (2, 1, 'Feb 2026', '2026-02-01', '2026-02-28')
            ");

            $this->Flash->success('Sandbox seeded successfully with 5 employees, 2 pay periods, and base accounts.');
        } catch (\Exception $e) {
            $this->Flash->error('Seeding failed: ' . $e->getMessage());
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reset Sandbox — truncates all tables in sandbox DB (structure preserved)
     */
    public function reset()
    {
        $this->request->allowMethod(['post']);

        try {
            $sandboxConn = ConnectionManager::get('sandbox');
            $sandboxConn->execute("SET FOREIGN_KEY_CHECKS = 0");

            $tables = $sandboxConn->getSchemaCollection()->listTables();
            foreach ($tables as $table) {
                $sandboxConn->execute("TRUNCATE TABLE `$table`");
            }

            $sandboxConn->execute("SET FOREIGN_KEY_CHECKS = 1");
            $this->Flash->success('Sandbox has been reset. All test data cleared.');
        } catch (\Exception $e) {
            $this->Flash->error('Reset failed: ' . $e->getMessage());
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle Sandbox Mode — switches session flag
     */
    public function toggleMode()
    {
        $this->request->allowMethod(['post']);
        $session = $this->request->getSession();
        $current = $session->read('Sandbox.active', false);
        $session->write('Sandbox.active', !$current);

        if (!$current) {
            $this->Flash->warning('⚠ SANDBOX MODE ACTIVATED. You are now working with test data only.');
        } else {
            $this->Flash->success('Sandbox mode deactivated. Returned to production.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
