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
     * Inject company_id into SELECT queries
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, bool $primary)
    {
        $tenantId = Configure::read('Tenant.company_id');
        
        // If a logged-in user is bound to a tenant, restrict all queries.
        // We bypass this completely if no tenant is set (e.g. CLI or SuperAdmin mode).
        if ($tenantId && $this->_table->hasField('company_id')) {
            // Check if condition is already present to prevent duplicates
            $isAlreadyRestricted = false;
            if ($query->clause('where')) {
                // Not perfectly reliable regex, but CakePHP applies where securely.
                // We just append it natively.
            }
            $query->where([$this->_table->aliasField('company_id') => $tenantId]);
        }
    }

    /**
     * Auto-stamp company_id on INSERT
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $tenantId = Configure::read('Tenant.company_id');
        
        if ($tenantId && $this->_table->hasField('company_id')) {
            if ($entity->isNew() && !$entity->get('company_id')) {
                $entity->set('company_id', $tenantId);
            }
        }
    }
}
