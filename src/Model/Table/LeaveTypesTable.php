<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeaveTypes Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\LeaveApplicationsTable&\Cake\ORM\Association\HasMany $LeaveApplications
 * @property \App\Model\Table\LeaveBalancesTable&\Cake\ORM\Association\HasMany $LeaveBalances
 *
 * @method \App\Model\Entity\LeaveType newEmptyEntity()
 * @method \App\Model\Entity\LeaveType newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveType> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LeaveType findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LeaveType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LeaveType saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveType>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveType> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveType>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveType> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LeaveTypesTable extends Table
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

        $this->setTable('leave_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('LeaveApplications', [
            'foreignKey' => 'leave_type_id',
        ]);
        $this->hasMany('LeaveBalances', [
            'foreignKey' => 'leave_type_id',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
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
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('default_days_per_year')
            ->notEmptyString('default_days_per_year');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
