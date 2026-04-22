<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Core\Configure;

class TenantAwareBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'isRoot' => false, // Set to true for the Companies table itself
    ];

    /**
     * Inject company_id into SELECT queries
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, bool $primary)
    {
        // Allow explicit bypass (needed for SuperAdmin switcher)
        if (!empty($options['ignoreTenant'])) {
            return;
        }

        $tenantId = Configure::read('Tenant.company_id');
        if (!$tenantId) {
            return;
        }

        // Standard multi-tenant tables (have company_id column)
        if ($this->_table->hasField('company_id')) {
            $query->where([$this->_table->aliasField('company_id') => $tenantId]);
            return;
        }

        // Special case: The root "Companies" table itself.
        // If it's the Companies table and we're bound to a tenant, filter by its own ID.
        if ($this->getConfig('isRoot') === true) {
            $primaryKey = $this->_table->getPrimaryKey();
            if (is_string($primaryKey)) {
                $query->where([$this->_table->aliasField($primaryKey) => $tenantId]);
            }
        }
    }

    /**
     * Inject company_id into raw data before it is marshalled into an entity.
     * This handles cases where validation(Default) requires company_id.
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options)
    {
        $tenantId = Configure::read('Tenant.company_id');
        if ($tenantId && $this->_table->hasField('company_id')) {
            $data['company_id'] = $tenantId;
        }
    }

    /**
     * Ensure company_id is set before Application Rules are checked.
     * Some rules (like existsIn or cross-table sum checks) depend on this ID.
     */
    public function beforeRules(EventInterface $event, EntityInterface $entity, ArrayObject $options, string $operation)
    {
        $tenantId = Configure::read('Tenant.company_id');
        if ($tenantId && $this->_table->hasField('company_id')) {
            $entity->set('company_id', $tenantId);
        }
    }

    /**
     * Auto-stamp company_id on INSERT/UPDATE as a final safety measure.
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $tenantId = Configure::read('Tenant.company_id');
        
        if ($tenantId && $this->_table->hasField('company_id')) {
            // Always enforce the current tenant ID to prevent cross-tenant injection
            $entity->set('company_id', $tenantId);
        }
    }
}
