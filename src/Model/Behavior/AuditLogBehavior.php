<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * AuditLog behavior
 * 
 * Automatically tracks 'CREATE', 'UPDATE', and 'DELETE' events across any Table
 * it is attached to, serializing the changed fields and stamping the active User.
 */
class AuditLogBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'ignoreProperties' => ['created', 'modified', 'updated']
    ];

    /**
     * Get the currently authenticated User ID from the session/request if possible.
     */
    protected function _getUserId(): ?int
    {
         try {
             $request = Router::getRequest();
             if ($request) {
                $identity = $request->getAttribute('identity');
                if ($identity) {
                    return (int)$identity->getIdentifier();
                }
             }
         } catch (\Exception $e) {
             // Request context not available (e.g. CLI or early bootstrap)
         }
         return null;
    }

    /**
     * Called after an entity is saved (Created or Updated).
     */
    public function afterSave(EventInterface $event, Entity $entity, ArrayObject $options): void
    {
        $isNew = $entity->isNew();
        $action = $isNew ? 'CREATE' : 'UPDATE';
        
        // Extract what exactly changed
        $changedFields = $entity->extractOriginalChanged($entity->getVisible());
        
        // Remove ignored properties like timestamps from the log
        foreach ($this->getConfig('ignoreProperties') as $prop) {
            unset($changedFields[$prop]);
        }

        // If it's an update and nothing meaningful changed, abort logging
        if (!$isNew && empty($changedFields)) {
            return;
        }

        $this->_logActivity($action, clone $entity, $changedFields);
    }

    /**
     * Called after an entity is deleted.
     */
    public function afterDelete(EventInterface $event, Entity $entity, ArrayObject $options): void
    {
        $this->_logActivity('DELETE', clone $entity, $entity->toArray());
    }

    /**
     * Recursively sanitize data so it can always be JSON-encoded.
     * Objects are converted to arrays, resources to a placeholder string,
     * and non-UTF-8 strings are transliterated.
     */
    protected function _sanitizeForJson(mixed $value): mixed
    {
        if (is_resource($value)) {
            return '[resource]';
        }
        if (is_object($value)) {
            if (method_exists($value, 'toArray')) {
                $value = $value->toArray();
            } elseif ($value instanceof \JsonSerializable) {
                $value = $value->jsonSerialize();
            } else {
                $value = (array)$value;
            }
        }
        if (is_array($value)) {
            return array_map([$this, '_sanitizeForJson'], $value);
        }
        if (is_string($value)) {
            // Replace any non-UTF-8 sequences so json_encode won't choke
            $clean = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            // Strip null bytes which are valid UTF-8 but invalid in MySQL JSON
            return str_replace("\0", '', $clean);
        }
        // scalar (int, float, bool, null) — always safe
        return $value;
    }

    /**
     * Internal method to write the payload to the AuditLogs table.
     */
    protected function _logActivity(string $action, Entity $entity, array $changedData): void
    {
        $tableAlias = $this->_table->getAlias();
        
        // Prevent infinite loops where AuditLogs tries to audit itself or system tables
        if (in_array($tableAlias, ['AuditLogs', 'Panels', 'Requests', 'Phinxlog', 'Sessions'])) {
            return;
        }

        $auditLogsTable = TableRegistry::getTableLocator()->get('AuditLogs');
        
        $log = $auditLogsTable->newEmptyEntity();
        $log->user_id = $this->_getUserId();
        
        // Explicitly set company_id from the entity being audited if available, 
        // or from the global Configure/Session via TenantAware logic.
        $log->company_id = $entity->get('company_id') ?: \Cake\Core\Configure::read('Tenant.company_id');

        $log->model = $tableAlias;
        // Primary key is usually 'id', but handle safety
        $primaryKey = (array)$this->_table->getPrimaryKey();
        $log->record_id = (string)($entity->get($primaryKey[0]) ?? 0);
        $log->action = $action;

        // Sanitize first so json_encode always succeeds and passes json_valid()
        $safeData = $this->_sanitizeForJson($changedData);
        $encoded = json_encode(
            $safeData,
            JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR
        );
        // Last-resort fallback: if encoding still fails, store a minimal JSON object
        $log->changed_data = ($encoded !== false) ? $encoded : '{"_error":"unencodable_data"}';
        
        if (!$auditLogsTable->save($log, ['atomic' => false, 'checkRules' => false])) {
            \Cake\Log\Log::error('AuditLog save failed: ' . json_encode($log->getErrors()));
        }
    }
}
