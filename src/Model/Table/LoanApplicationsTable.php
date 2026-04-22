<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanApplications Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\LoanProductsTable&\Cake\ORM\Association\BelongsTo $LoanProducts
 * @property \App\Model\Table\LoanGuarantorsTable&\Cake\ORM\Association\HasMany $LoanGuarantors
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\HasMany $Loans
 *
 * @method \App\Model\Entity\LoanApplication newEmptyEntity()
 * @method \App\Model\Entity\LoanApplication newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanApplication> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanApplication get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanApplication findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanApplication patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanApplication> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanApplication|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanApplication saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanApplication>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanApplication>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanApplication>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanApplication> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanApplication>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanApplication>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanApplication>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanApplication> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanApplicationsTable extends Table
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

        $this->setTable('loan_applications');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('LoanProducts', [
            'foreignKey' => 'loan_product_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('LoanGuarantors', [
            'foreignKey' => 'loan_application_id',
        ]);
        $this->hasMany('Loans', [
            'foreignKey' => 'loan_application_id',
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
            ->integer('loan_product_id')
            ->notEmptyString('loan_product_id');

        $validator
            ->decimal('amount_requested')
            ->requirePresence('amount_requested', 'create')
            ->notEmptyString('amount_requested');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->integer('term')
            ->requirePresence('term', 'create')
            ->notEmptyString('term');

        $validator
            ->scalar('purpose')
            ->maxLength('purpose', 255)
            ->allowEmptyString('purpose');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->dateTime('submitted_at')
            ->allowEmptyDateTime('submitted_at');

        $validator
            ->dateTime('decided_at')
            ->allowEmptyDateTime('decided_at');

        $validator
            ->integer('decided_by')
            ->allowEmptyString('decided_by');

        $validator
            ->scalar('rejection_reason')
            ->allowEmptyString('rejection_reason');

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
        $rules->add($rules->existsIn(['client_id'], 'LoanClients'), ['errorField' => 'client_id']);
        $rules->add($rules->existsIn(['loan_product_id'], 'LoanProducts'), ['errorField' => 'loan_product_id']);

        return $rules;
    }
}
