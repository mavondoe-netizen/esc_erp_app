<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanDisbursements Model
 *
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\LoanDisbursement newEmptyEntity()
 * @method \App\Model\Entity\LoanDisbursement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanDisbursement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanDisbursement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanDisbursement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanDisbursement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanDisbursement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanDisbursement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanDisbursement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDisbursement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDisbursement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDisbursement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDisbursement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDisbursement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDisbursement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanDisbursement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanDisbursement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanDisbursementsTable extends Table
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

        $this->setTable('loan_disbursements');
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
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('method')
            ->maxLength('method', 30)
            ->notEmptyString('method');

        $validator
            ->scalar('bank_reference')
            ->maxLength('bank_reference', 200)
            ->allowEmptyString('bank_reference');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

        $validator
            ->integer('disbursed_by')
            ->allowEmptyString('disbursed_by');

        $validator
            ->dateTime('disbursed_at')
            ->allowEmptyDateTime('disbursed_at');

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
