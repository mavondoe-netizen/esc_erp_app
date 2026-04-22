<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanProducts Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\LoanApplicationsTable&\Cake\ORM\Association\HasMany $LoanApplications
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\HasMany $Loans
 *
 * @method \App\Model\Entity\LoanProduct newEmptyEntity()
 * @method \App\Model\Entity\LoanProduct newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanProduct> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanProduct get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanProduct findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanProduct> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanProduct|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanProduct>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanProduct> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanProduct>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanProduct>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanProduct> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanProductsTable extends Table
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

        $this->setTable('loan_products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('LoanApplications', [
            'foreignKey' => 'loan_product_id',
        ]);
        $this->hasMany('Loans', [
            'foreignKey' => 'loan_product_id',
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->decimal('interest_rate')
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
            ->decimal('min_amount')
            ->notEmptyString('min_amount');

        $validator
            ->decimal('max_amount')
            ->notEmptyString('max_amount');

        $validator
            ->integer('max_term')
            ->notEmptyString('max_term');

        $validator
            ->integer('min_term')
            ->notEmptyString('min_term');

        $validator
            ->integer('grace_period_days')
            ->notEmptyString('grace_period_days');

        $validator
            ->decimal('penalty_rate')
            ->notEmptyString('penalty_rate');

        $validator
            ->boolean('requires_guarantor')
            ->notEmptyString('requires_guarantor');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
