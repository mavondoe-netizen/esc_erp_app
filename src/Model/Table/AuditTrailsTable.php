<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuditTrails Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\AuditTrail newEmptyEntity()
 * @method \App\Model\Entity\AuditTrail newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditTrail> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AuditTrail findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AuditTrail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditTrail> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AuditTrail saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AuditTrail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditTrail>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditTrail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditTrail> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditTrail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditTrail>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditTrail>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditTrail> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditTrailsTable extends Table
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

        $this->setTable('audit_trails');
        $this->setDisplayField('entity_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
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
            ->scalar('entity_type')
            ->maxLength('entity_type', 151)
            ->requirePresence('entity_type', 'create')
            ->notEmptyString('entity_type');

        $validator
            ->integer('entity_id')
            ->requirePresence('entity_id', 'create')
            ->notEmptyString('entity_id');

        $validator
            ->scalar('action')
            ->maxLength('action', 50)
            ->requirePresence('action', 'create')
            ->notEmptyString('action');

        $validator
            ->scalar('description')
            ->maxLength('description', 50)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
