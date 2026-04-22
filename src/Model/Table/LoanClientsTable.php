<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanClients Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\LoanClient newEmptyEntity()
 * @method \App\Model\Entity\LoanClient newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanClient> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanClient get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanClient findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanClient> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanClient|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanClient saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanClient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanClient>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanClient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanClient> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanClient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanClient>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanClient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanClient> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanClientsTable extends Table
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

        $this->setTable('loan_clients');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Employees', [
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
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->integer('employee_id')
            ->allowEmptyString('employee_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('national_id')
            ->maxLength('national_id', 100)
            ->allowEmptyString('national_id');

        $validator
            ->date('dob')
            ->allowEmptyDate('dob');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 20)
            ->allowEmptyString('gender');

        $validator
            ->scalar('employer_name')
            ->maxLength('employer_name', 200)
            ->allowEmptyString('employer_name');

        $validator
            ->scalar('employment_type')
            ->maxLength('employment_type', 50)
            ->allowEmptyString('employment_type');

        $validator
            ->decimal('monthly_income')
            ->notEmptyString('monthly_income');

        $validator
            ->scalar('income_currency')
            ->maxLength('income_currency', 10)
            ->notEmptyString('income_currency');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 50)
            ->allowEmptyString('contact_phone');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 200)
            ->allowEmptyString('contact_email');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }
}
