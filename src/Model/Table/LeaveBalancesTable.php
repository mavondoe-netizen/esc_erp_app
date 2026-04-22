<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeaveBalances Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\LeaveTypesTable&\Cake\ORM\Association\BelongsTo $LeaveTypes
 *
 * @method \App\Model\Entity\LeaveBalance newEmptyEntity()
 * @method \App\Model\Entity\LeaveBalance newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveBalance> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveBalance get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LeaveBalance findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LeaveBalance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveBalance> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveBalance|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LeaveBalance saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveBalance>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveBalance>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveBalance>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveBalance> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveBalance>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveBalance>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveBalance>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveBalance> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 */
class LeaveBalancesTable extends Table
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

        $this->setTable('leave_balances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LeaveTypes', [
            'foreignKey' => 'leave_type_id',
            'joinType' => 'INNER',
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
            ->integer('employee_id')
            ->notEmptyString('employee_id');

        $validator
            ->integer('leave_type_id')
            ->notEmptyString('leave_type_id');

        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year');

        $validator
            ->decimal('days_entitled')
            ->notEmptyString('days_entitled');

        $validator
            ->decimal('days_taken')
            ->notEmptyString('days_taken');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

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
        $rules->add($rules->isUnique(['employee_id', 'leave_type_id', 'year']), ['errorField' => 'employee_id']);
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);
        $rules->add($rules->existsIn(['leave_type_id'], 'LeaveTypes'), ['errorField' => 'leave_type_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
