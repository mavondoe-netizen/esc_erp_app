<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payslips Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\PayPeriodsTable&\Cake\ORM\Association\BelongsTo $PayPeriods
 *
 * @method \App\Model\Entity\Payslip newEmptyEntity()
 * @method \App\Model\Entity\Payslip newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Payslip> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payslip get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Payslip findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Payslip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Payslip> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payslip|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Payslip saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Payslip>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Payslip>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Payslip>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Payslip> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Payslip>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Payslip>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Payslip>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Payslip> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PayslipsTable extends Table
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

        $this->setTable('payslips');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PayPeriods', [
            'foreignKey' => 'pay_period_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PayslipItems', [
            'foreignKey' => 'payslip_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->integer('pay_period_id')
            ->notEmptyString('pay_period_id');

        $validator
            ->decimal('gross_pay')
            ->requirePresence('gross_pay', 'create')
            ->notEmptyString('gross_pay');

        $validator
            ->decimal('deductions')
            ->allowEmptyString('deductions');

        $validator
            ->decimal('net_pay')
            ->requirePresence('net_pay', 'create')
            ->notEmptyString('net_pay');

        $validator
            ->date('generated_date')
            ->requirePresence('generated_date', 'create')
            ->notEmptyDate('generated_date');

        $validator
            ->decimal('basic_salary')
            ->allowEmptyString('basic_salary');

        $validator
            ->decimal('allowances')
            ->allowEmptyString('allowances');

        $validator
            ->decimal('bonuses')
            ->allowEmptyString('bonuses');

        $validator
            ->decimal('overtime')
            ->allowEmptyString('overtime');

        $validator
            ->decimal('benefits')
            ->allowEmptyString('benefits');

        $validator
            ->decimal('pension')
            ->allowEmptyString('pension');

        $validator
            ->decimal('nssa')
            ->allowEmptyString('nssa');

        $validator
            ->decimal('medical_aid')
            ->allowEmptyString('medical_aid');

        $validator
            ->decimal('medical_expenses')
            ->allowEmptyString('medical_expenses');

        $validator
            ->decimal('taxable_income')
            ->allowEmptyString('taxable_income');

        $validator
            ->decimal('paye')
            ->allowEmptyString('paye');

        $validator
            ->decimal('tax_credits')
            ->allowEmptyString('tax_credits');

        $validator
            ->decimal('aids_levy')
            ->allowEmptyString('aids_levy');

        $validator
            ->decimal('total_tax')
            ->allowEmptyString('total_tax');

        $validator
            ->decimal('exchange_rate')
            ->notEmptyString('exchange_rate');

        $validator
            ->decimal('usd_gross')
            ->notEmptyString('usd_gross');

        $validator
            ->decimal('usd_deductions')
            ->notEmptyString('usd_deductions');

        $validator
            ->decimal('usd_net')
            ->notEmptyString('usd_net');

        $validator
            ->decimal('zwg_gross')
            ->notEmptyString('zwg_gross');

        $validator
            ->decimal('zwg_deductions')
            ->notEmptyString('zwg_deductions');

        $validator
            ->decimal('zwg_net')
            ->notEmptyString('zwg_net');

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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);
        $rules->add($rules->existsIn(['pay_period_id'], 'PayPeriods'), ['errorField' => 'pay_period_id']);
        $rules->add($rules->isUnique(['employee_id', 'pay_period_id'], 'This employee already has a payslip for this pay period.'));

        return $rules;
    }
}
