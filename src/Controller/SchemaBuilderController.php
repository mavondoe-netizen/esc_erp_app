<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Database\Schema\TableSchema;

/**
 * SchemaBuilder Controller
 *
 * Dynamic schema introspection and table/field management tool
 * for super-admin users.
 */
class SchemaBuilderController extends AppController
{
    /**
     * Index — show list of all database tables.
     *
     * @return void
     */
    public function index()
    {
        $connection = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $connection->getSchemaCollection()->listTables();
        $this->set(compact('tables'));
    }

    /**
     * Add a new table to the database.
     *
     * @return \Cake\Http\Response|null
     */
    public function addTable()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $tableName = preg_replace('/[^a-z0-9_]/', '', strtolower(trim($data['table_name'] ?? '')));

            if (empty($tableName)) {
                $this->Flash->error('Invalid table name.');
                return null;
            }

            $connection = \Cake\Datasource\ConnectionManager::get('default');
            try {
                $connection->execute(
                    "CREATE TABLE IF NOT EXISTS `$tableName` (
                        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `company_id` INT UNSIGNED NOT NULL,
                        `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
                        `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        INDEX (`company_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
                );
                $this->Flash->success("Table '$tableName' created successfully.");
                return $this->redirect(['action' => 'index']);
            } catch (\Exception $e) {
                $this->Flash->error('Error creating table: ' . $e->getMessage());
            }
        }
    }

    /**
     * Add a field (column) to an existing table.
     *
     * @return \Cake\Http\Response|null
     */
    public function addField()
    {
        if ($this->request->is('post')) {
            $data      = $this->request->getData();
            $tableName = preg_replace('/[^a-z0-9_]/', '', strtolower(trim($data['table_name'] ?? '')));
            $fieldName = preg_replace('/[^a-z0-9_]/', '', strtolower(trim($data['field_name'] ?? '')));
            $fieldType = $data['field_type'] ?? 'VARCHAR(255)';
            $nullable  = !empty($data['nullable']) ? 'NULL' : 'NOT NULL';
            $default   = isset($data['default_value']) && $data['default_value'] !== ''
                ? "DEFAULT '" . addslashes($data['default_value']) . "'"
                : 'DEFAULT NULL';

            if (empty($tableName) || empty($fieldName)) {
                $this->Flash->error('Table name and field name are required.');
                return null;
            }

            $connection = \Cake\Datasource\ConnectionManager::get('default');
            try {
                $connection->execute(
                    "ALTER TABLE `$tableName` ADD COLUMN `$fieldName` $fieldType $nullable $default"
                );
                $this->Flash->success("Field '$fieldName' added to '$tableName'.");
                return $this->redirect(['action' => 'index']);
            } catch (\Exception $e) {
                $this->Flash->error('Error adding field: ' . $e->getMessage());
            }
        }

        $connection = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $connection->getSchemaCollection()->listTables();
        $this->set(compact('tables'));
    }
}
