<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ZimraReconciliations Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\PayPeriodsTable&\Cake\ORM\Association\BelongsTo $PayPeriods
 *
 * @method \App\Model\Entity\ZimraReconciliation newEmptyEntity()
 * @method \App\Model\Entity\ZimraReconciliation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ZimraReconciliation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ZimraReconciliation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ZimraReconciliation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ZimraReconciliation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ZimraReconciliation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ZimraReconciliation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ZimraReconciliation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ZimraReconciliation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ZimraReconciliation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ZimraReconciliation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ZimraReconciliation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ZimraReconciliation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ZimraReconciliation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ZimraReconciliation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ZimraReconciliation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ZimraReconciliationsTable extends Table
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

        $this->setTable('zimra_reconciliations');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PayPeriods', [
            'foreignKey' => 'pay_period_id',
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
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->integer('employee_id')
            ->notEmptyString('employee_id');

        $validator
            ->integer('pay_period_id')
            ->notEmptyString('pay_period_id');

        $validator
            ->decimal('payroll_tax_amount')
            ->notEmptyString('payroll_tax_amount');

        $validator
            ->decimal('assessed_tax_amount')
            ->notEmptyString('assessed_tax_amount');

        $validator
            ->decimal('variance')
            ->notEmptyString('variance');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        $validator
            ->date('cleared_date')
            ->allowEmptyDate('cleared_date');

        $validator
            ->scalar('cleared_via')
            ->maxLength('cleared_via', 255)
            ->allowEmptyString('cleared_via');

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
        $rules->add($rules->isUnique(['company_id', 'employee_id', 'pay_period_id']), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['employee_id'], 'Employees'), ['errorField' => 'employee_id']);
        $rules->add($rules->existsIn(['pay_period_id'], 'PayPeriods'), ['errorField' => 'pay_period_id']);

        return $rules;
    }
}
