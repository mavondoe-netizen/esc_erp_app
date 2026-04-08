<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanWriteoffs Model
 *
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\LoanWriteoff newEmptyEntity()
 * @method \App\Model\Entity\LoanWriteoff newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanWriteoff> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanWriteoff get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanWriteoff findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanWriteoff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanWriteoff> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanWriteoff|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanWriteoff saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanWriteoff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanWriteoff>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanWriteoff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanWriteoff> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanWriteoff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanWriteoff>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanWriteoff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanWriteoff> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanWriteoffsTable extends Table
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

        $this->setTable('loan_writeoffs');
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
            ->decimal('outstanding_at_writeoff')
            ->allowEmptyString('outstanding_at_writeoff');

        $validator
            ->scalar('reason')
            ->allowEmptyString('reason');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

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
