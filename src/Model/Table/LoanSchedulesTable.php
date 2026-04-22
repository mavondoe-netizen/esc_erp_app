<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanSchedules Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\LoanSchedule newEmptyEntity()
 * @method \App\Model\Entity\LoanSchedule newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanSchedule> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanSchedule get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanSchedule findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanSchedule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanSchedule> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanSchedule|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanSchedule saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanSchedule>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanSchedule>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanSchedule>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanSchedule> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanSchedule>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanSchedule>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanSchedule>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanSchedule> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanSchedulesTable extends Table
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

        $this->setTable('loan_schedules');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Loans', [
            'foreignKey' => 'loan_id',
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
            ->integer('loan_id')
            ->notEmptyString('loan_id');

        $validator
            ->integer('period_number')
            ->requirePresence('period_number', 'create')
            ->notEmptyString('period_number');

        $validator
            ->date('due_date')
            ->requirePresence('due_date', 'create')
            ->notEmptyDate('due_date');

        $validator
            ->decimal('principal_due')
            ->notEmptyString('principal_due');

        $validator
            ->decimal('interest_due')
            ->notEmptyString('interest_due');

        $validator
            ->decimal('penalty_due')
            ->notEmptyString('penalty_due');

        $validator
            ->decimal('total_due')
            ->notEmptyString('total_due');

        $validator
            ->decimal('amount_paid')
            ->notEmptyString('amount_paid');

        $validator
            ->decimal('balance')
            ->notEmptyString('balance');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['loan_id'], 'Loans'), ['errorField' => 'loan_id']);

        return $rules;
    }
}
