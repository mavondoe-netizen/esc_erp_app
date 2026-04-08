<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanRepayments Model
 *
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\LoanRepayment newEmptyEntity()
 * @method \App\Model\Entity\LoanRepayment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanRepayment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanRepayment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanRepayment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanRepayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanRepayment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanRepayment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanRepayment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRepayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRepayment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRepayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRepayment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRepayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRepayment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRepayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRepayment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanRepaymentsTable extends Table
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

        $this->setTable('loan_repayments');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Loans', [
            'foreignKey' => 'loan_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->integer('client_id')
            ->allowEmptyString('client_id');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('source')
            ->maxLength('source', 30)
            ->notEmptyString('source');

        $validator
            ->date('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmptyDate('payment_date');

        $validator
            ->decimal('penalty_paid')
            ->notEmptyString('penalty_paid');

        $validator
            ->decimal('interest_paid')
            ->notEmptyString('interest_paid');

        $validator
            ->decimal('principal_paid')
            ->notEmptyString('principal_paid');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 150)
            ->allowEmptyString('reference');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

        $validator
            ->integer('processed_by')
            ->allowEmptyString('processed_by');

        $validator
            ->scalar('allocation_json')
            ->allowEmptyString('allocation_json');

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
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);

        return $rules;
    }
}
