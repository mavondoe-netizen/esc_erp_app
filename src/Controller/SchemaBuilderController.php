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
     * @param string|null $tableName The table to add fields to
     * @return \Cake\Http\Response|null
     */
    public function addField($tableName = null)
    {
        if (!$tableName) {
            $this->Flash->error('No table specified.');
            return $this->redirect(['action' => 'index']);
        }

        $connection = \Cake\Datasource\ConnectionManager::get('default');
        $schemaCollection = $connection->getSchemaCollection();
        
        $tables = $schemaCollection->listTables();
        if (!in_array($tableName, $tables)) {
            $this->Flash->error('Table not found.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            if (!empty($data['fields']) && is_array($data['fields'])) {
                try {
                    $connection->begin();
                    foreach ($data['fields'] as $field) {
                        $fieldName = preg_replace('/[^a-z0-9_]/', '', strtolower(trim($field['name'] ?? '')));
                        $fieldType = $field['type'] ?? 'string';
                        
                        if (empty($fieldName)) continue;
                        
                        $sqlType = 'VARCHAR(255)';
                        switch ($fieldType) {
                            case 'text': $sqlType = 'TEXT'; break;
                            case 'int': $sqlType = 'INT'; break;
                            case 'decimal': $sqlType = 'DECIMAL(10,2)'; break;
                            case 'boolean': $sqlType = 'TINYINT(1) DEFAULT 0'; break;
                            case 'date': $sqlType = 'DATE'; break;
                            case 'datetime': $sqlType = 'DATETIME'; break;
                        }

                        $connection->execute("ALTER TABLE `$tableName` ADD COLUMN `$fieldName` $sqlType");
                    }
                    $connection->commit();
                    $this->Flash->success('Schema updated successfully.');
                    return $this->redirect(['action' => 'index']);
                } catch (\Exception $e) {
                    $connection->rollback();
                    $this->Flash->error('Error updating schema: ' . $e->getMessage());
                }
            } else {
                $this->Flash->error('No fields to add.');
            }
        }

        $tableSchema = $schemaCollection->describe($tableName);
        $existingFields = [];
        foreach ($tableSchema->columns() as $col) {
            $existingFields[] = [
                'name' => $col,
                'type' => $tableSchema->getColumnType($col)
            ];
        }

        $this->set(compact('tableName', 'existingFields'));
    }
}
