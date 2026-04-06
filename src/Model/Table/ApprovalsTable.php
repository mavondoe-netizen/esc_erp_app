<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Approvals Model
 *
 * @method \App\Model\Entity\Approval newEmptyEntity()
 * @method \App\Model\Entity\Approval newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Approval> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Approval get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Approval findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Approval patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Approval> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Approval|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Approval saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Approval>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Approval>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Approval>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Approval> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Approval>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Approval>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Approval>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Approval> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApprovalsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('TenantAware');

        $this->setTable('approvals');
        $this->setDisplayField('table_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('table_name')
            ->maxLength('table_name', 100)
            ->requirePresence('table_name', 'create')
            ->notEmptyString('table_name');

        $validator
            ->integer('entity_id')
            ->requirePresence('entity_id', 'create')
            ->notEmptyString('entity_id');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->integer('initiated_by')
            ->requirePresence('initiated_by', 'create')
            ->notEmptyString('initiated_by');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

        return $validator;
    }
}
