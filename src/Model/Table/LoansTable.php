<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Loans Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\LoanApplicationsTable&\Cake\ORM\Association\BelongsTo $LoanApplications
 * @property \App\Model\Table\LoanProductsTable&\Cake\ORM\Association\BelongsTo $LoanProducts
 * @property \App\Model\Table\DelinquencyFlagsTable&\Cake\ORM\Association\HasMany $DelinquencyFlags
 * @property \App\Model\Table\LoanDeductionsTable&\Cake\ORM\Association\HasMany $LoanDeductions
 * @property \App\Model\Table\LoanDisbursementsTable&\Cake\ORM\Association\HasMany $LoanDisbursements
 * @property \App\Model\Table\LoanRepaymentsTable&\Cake\ORM\Association\HasMany $LoanRepayments
 * @property \App\Model\Table\LoanRestructuresTable&\Cake\ORM\Association\HasMany $LoanRestructures
 * @property \App\Model\Table\LoanSchedulesTable&\Cake\ORM\Association\HasMany $LoanSchedules
 * @property \App\Model\Table\LoanWriteoffsTable&\Cake\ORM\Association\HasMany $LoanWriteoffs
 *
 * @method \App\Model\Entity\Loan newEmptyEntity()
 * @method \App\Model\Entity\Loan newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Loan> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Loan get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Loan findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Loan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Loan> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Loan|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Loan saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Loan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Loan>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Loan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Loan> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Loan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Loan>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Loan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Loan> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoansTable extends Table
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

        $this->setTable('loans');
        $this->setDisplayField('interest_method');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', ['foreignKey' => 'company_id']);
        $this->belongsTo('LoanClients', ['foreignKey' => 'client_id']);
        $this->belongsTo('LoanApplications', ['foreignKey' => 'loan_application_id']);
        $this->belongsTo('LoanProducts', ['foreignKey' => 'loan_product_id']);
        $this->hasMany('DelinquencyFlags', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanDeductions', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanDisbursements', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanRepayments', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanRestructures', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanSchedules', [
            'foreignKey' => 'loan_id',
        ]);
        $this->hasMany('LoanWriteoffs', [
            'foreignKey' => 'loan_id',
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
            ->integer('client_id')
            ->requirePresence('client_id', 'create')
            ->notEmptyString('client_id');

        $validator
            ->integer('loan_application_id')
            ->allowEmptyString('loan_application_id');

        $validator
            ->integer('loan_product_id')
            ->allowEmptyString('loan_product_id');

        $validator
            ->scalar('loan_account_no')
            ->maxLength('loan_account_no', 50)
            ->allowEmptyString('loan_account_no');

        $validator
            ->decimal('principal')
            ->requirePresence('principal', 'create')
            ->notEmptyString('principal');

        $validator
            ->decimal('outstanding_balance')
            ->requirePresence('outstanding_balance', 'create')
            ->notEmptyString('outstanding_balance');

        $validator
            ->decimal('interest_rate')
            ->requirePresence('interest_rate', 'create')
            ->notEmptyString('interest_rate');

        $validator
            ->scalar('interest_method')
            ->maxLength('interest_method', 20)
            ->notEmptyString('interest_method');

        $validator
            ->scalar('repayment_frequency')
            ->maxLength('repayment_frequency', 20)
            ->notEmptyString('repayment_frequency');

        $validator
            ->integer('term')
            ->requirePresence('term', 'create')
            ->notEmptyString('term');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('maturity_date')
            ->allowEmptyDate('maturity_date');

        $validator
            ->dateTime('disbursed_at')
            ->allowEmptyDateTime('disbursed_at');

        $validator
            ->date('last_payment_date')
            ->allowEmptyDate('last_payment_date');

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
        // FK rules relaxed — company_id/loan_application_id/loan_product_id are nullable
        return $rules;
    }
}
