<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Event\EventInterface;
use Cake\Utility\Inflector;

/**
 * SchemaBuilder Controller
 *
 * Allows Super Admins to dynamically create models (tables) and add fields (columns).
 */
class SchemaBuilderController extends AppController
{
    /**
     * Ensure only Admins/Super Admins can access this structural builder.
     */
    public function beforeFilter(EventInterface $event)
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
            $this->Flash->error(__('You are not authorized to access the Schema Builder.'));
            return $this->redirect('/');
        }
    }

    /**
     * Index method: Lists all available database tables
     */
    public function index()
    {
        $connection = ConnectionManager::get('default');
        $schemaCollection = $connection->getSchemaCollection();
        $tables = $schemaCollection->listTables();
        
        // Exclude system schema tables like phinxlog if necessary
        $tables = array_filter($tables, function($t) {
            return $t !== 'phinxlog';
        });

        $this->set(compact('tables'));
    }

    /**
     * Add a new Table (Entity wrapper)
     */
    public function addTable()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $tableName = strtolower(trim($data['table_name']));
            
            // Basic validation
            if (empty($tableName) || !preg_match('/^[a-z_]+$/', $tableName)) {
                $this->Flash->error(__('Invalid table name. Use only lowercase letters and underscores.'));
                return;
            }

            try {
                $connection = ConnectionManager::get('default');
                // Create table schema with id, created, modified
                $sql = "CREATE TABLE IF NOT EXISTS `{$tableName}` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
                
                $connection->execute($sql);

                // Run CakePHP Bake command via shell
                $cakeCmd = ROOT . DS . 'bin' . DS . 'cake.bat bake all ' . escapeshellarg($tableName);
                
                // execute in background or wait for it
                exec($cakeCmd, $output, $returnVar);

                if ($returnVar === 0) {
                    $this->Flash->success(__("Table '{0}' created and baked successfully.", $tableName));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->warning(__("Table '{0}' created in DB, but baking failed. Output: {1}", $tableName, implode(" ", $output)));
                    return $this->redirect(['action' => 'index']);
                }
                
            } catch (\Exception $e) {
                $this->Flash->error(__('Error creating table: {0}', $e->getMessage()));
            }
        }
    }

    /**
     * Add a Field (Column) to an existing table
     */
    public function addField($tableName = null)
    {
        if (!$tableName) {
            return $this->redirect(['action' => 'index']);
        }

        $connection = ConnectionManager::get('default');
        $schemaCollection = $connection->getSchemaCollection();
        $tables = $schemaCollection->listTables();
        
        if (!in_array($tableName, $tables)) {
            $this->Flash->error(__('Table does not exist.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $newFields = $data['fields'] ?? []; // Expecting an array of ['name' => ..., 'type' => ...]
            
            // If it's a single field (old form fallback)
            if (empty($newFields) && !empty($data['field_name'])) {
                $newFields[] = [
                    'name' => $data['field_name'],
                    'type' => $data['field_type']
                ];
            }

            if (empty($newFields)) {
                $this->Flash->error(__('No fields provided.'));
            } else {
                try {
                    $connection = ConnectionManager::get('default');
                    $successCount = 0;
                    $errorLogs = [];

                    $tableSchema = $schemaCollection->describe($tableName);
                    $existingFieldNames = $tableSchema->columns();

                    foreach ($newFields as $f) {
                        $fieldName = strtolower(trim($f['name']));
                        $fieldType = $f['type'];
                        
                        if (empty($fieldName) || !preg_match('/^[a-z_]+$/', $fieldName)) {
                            $errorLogs[] = "Invalid field name: {$fieldName}";
                            continue;
                        }

                        if (in_array($fieldName, $existingFieldNames)) {
                            $errorLogs[] = "Field '{$fieldName}' already exists in '{$tableName}'.";
                            continue;
                        }

                        // Map UI field choices to SQL
                        $sqlType = 'VARCHAR(255)';
                        switch ($fieldType) {
                            case 'int': $sqlType = 'INT'; break;
                            case 'text': $sqlType = 'TEXT'; break;
                            case 'date': $sqlType = 'DATE'; break;
                            case 'datetime': $sqlType = 'DATETIME'; break;
                            case 'decimal': $sqlType = 'DECIMAL(10,2)'; break;
                            case 'boolean': $sqlType = 'TINYINT(1) DEFAULT 0'; break;
                        }

                        $sql = "ALTER TABLE `{$tableName}` ADD COLUMN `{$fieldName}` {$sqlType} NULL;";
                        $connection->execute($sql);
                        $successCount++;
                    }

                    if ($successCount > 0) {
                        // Re-bake model and template once
                        $bakeModelCmd = ROOT . DS . 'bin' . DS . 'cake.bat bake model ' . escapeshellarg($tableName) . ' -f';
                        $bakeTemplateCmd = ROOT . DS . 'bin' . DS . 'cake.bat bake template ' . escapeshellarg($tableName) . ' -f';
                        
                        exec($bakeModelCmd, $out1, $ret1);
                        exec($bakeTemplateCmd, $out2, $ret2);

                        if ($ret1 === 0 && $ret2 === 0) {
                            $this->Flash->success(__("{0} fields added to '{1}' and codebase re-baked successfully.", $successCount, $tableName));
                        } else {
                            $this->Flash->warning(__("{0} fields added, but baking failed for some modules.", $successCount));
                        }
                    }

                    if (!empty($errorLogs)) {
                        foreach ($errorLogs as $err) $this->Flash->error($err);
                    }

                    return $this->redirect(['action' => 'index']);
                    
                } catch (\Exception $e) {
                    $this->Flash->error(__('Error adding fields: {0}', $e->getMessage()));
                }
            }
        }

        $this->set(compact('tableName'));
        
        // Fetch existing columns to display
        $tableSchema = $schemaCollection->describe($tableName);
        $existingFields = [];
        foreach ($tableSchema->columns() as $column) {
            $existingFields[] = [
                'name' => $column,
                'type' => $tableSchema->getColumn($column)['type'],
                'null' => $tableSchema->getColumn($column)['null'] ? 'Yes' : 'No'
            ];
        }
        $this->set(compact('existingFields'));
    }
}
