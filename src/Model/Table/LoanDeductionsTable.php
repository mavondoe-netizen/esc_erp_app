<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanDeductions Model
 *
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\LoanDeduction newEmptyEntity()
 * @method \App\Model\Entity\LoanDeduction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanDeduction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanDeduction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanDeduction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanDeduction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanDeduction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanDeduction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanDeduction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDeduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDeduction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDeduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDeduction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDeduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDeduction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDeduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDeduction> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanDeductionsTable extends Table
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

        $this->setTable('loan_deductions');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Loans', [
            'foreignKey' => 'loan_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
            ->integer('loan_id')
            ->notEmptyString('loan_id');

        $validator
            ->integer('employee_id')
            ->notEmptyString('employee_id');

        $validator
            ->decimal('monthly_amount')
            ->requirePresence('monthly_amount', 'create')
            ->notEmptyString('monthly_amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

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
        $rules->add($rules->existsIn(['loan_id'], 'Loans'), ['errorField' => 'loan_id']);
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);

        return $rules;
    }
}
