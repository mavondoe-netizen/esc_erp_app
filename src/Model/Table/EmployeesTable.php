<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @property \App\Model\Table\PayslipsTable&\Cake\ORM\Association\HasMany $Payslips
 *
 * @method \App\Model\Entity\Employee newEmptyEntity()
 * @method \App\Model\Entity\Employee newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Employee> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Employee findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Employee> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Employee saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends Table
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

        $this->setTable('employees');
        $this->setDisplayField('employee_code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Claims', [
            'foreignKey' => 'employee_id',
        ]);
        $this->hasMany('LeaveApplications', [
            'foreignKey' => 'employee_id',
        ]);
        $this->hasMany('LeaveBalances', [
            'foreignKey' => 'employee_id',
        ]);
        $this->hasMany('Payslips', [
            'foreignKey' => 'employee_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'employee_id',
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
            ->scalar('employee_code')
            ->maxLength('employee_code', 20)
            ->requirePresence('employee_code', 'create')
            ->notEmptyString('employee_code')
            ->add('employee_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->integer('nssa_number')
            ->requirePresence('nssa_number', 'create')
            ->notEmptyString('nssa_number');

        $validator
            ->integer('tax_number')
            ->requirePresence('tax_number', 'create')
            ->notEmptyString('tax_number');

        $validator
            ->date('date_of_birth')
            ->requirePresence('date_of_birth', 'create')
            ->notEmptyDate('date_of_birth');

        $validator
            ->boolean('disabled')
            ->requirePresence('disabled', 'create')
            ->notEmptyString('disabled');

        $validator
            ->scalar('designation')
            ->maxLength('designation', 100)
            ->allowEmptyString('designation');

        $validator
            ->decimal('basic_salary')
            ->requirePresence('basic_salary', 'create')
            ->notEmptyString('basic_salary');

        $validator
            ->scalar('national_identity')
            ->maxLength('national_identity', 255)
            ->allowEmptyString('national_identity');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->boolean('is_blind')
            ->notEmptyString('is_blind');

        $validator
            ->scalar('usd_bank')
            ->maxLength('usd_bank', 100)
            ->allowEmptyString('usd_bank');

        $validator
            ->scalar('usd_branch')
            ->maxLength('usd_branch', 100)
            ->allowEmptyString('usd_branch');

        $validator
            ->scalar('usd_account')
            ->maxLength('usd_account', 50)
            ->allowEmptyString('usd_account');

        $validator
            ->scalar('zwg_bank')
            ->maxLength('zwg_bank', 100)
            ->allowEmptyString('zwg_bank');

        $validator
            ->scalar('zwg_branch')
            ->maxLength('zwg_branch', 100)
            ->allowEmptyString('zwg_branch');

        $validator
            ->scalar('zwg_account')
            ->maxLength('zwg_account', 50)
            ->allowEmptyString('zwg_account');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('termination_date')
            ->allowEmptyDate('termination_date');

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
        $rules->add($rules->isUnique(['employee_code']), ['errorField' => 'employee_code']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
