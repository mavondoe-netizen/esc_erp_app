<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanRestructures Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\LoanRestructure newEmptyEntity()
 * @method \App\Model\Entity\LoanRestructure newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanRestructure> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanRestructure get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanRestructure findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanRestructure patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanRestructure> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanRestructure|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanRestructure saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRestructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRestructure>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRestructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRestructure> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRestructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRestructure>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanRestructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanRestructure> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanRestructuresTable extends Table
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

        $this->setTable('loan_restructures');
        $this->setDisplayField('status');
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
            ->integer('old_term')
            ->allowEmptyString('old_term');

        $validator
            ->integer('new_term')
            ->requirePresence('new_term', 'create')
            ->notEmptyString('new_term');

        $validator
            ->decimal('old_rate')
            ->allowEmptyString('old_rate');

        $validator
            ->decimal('new_rate')
            ->allowEmptyString('new_rate');

        $validator
            ->decimal('outstanding_at_restructure')
            ->allowEmptyString('outstanding_at_restructure');

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
            ->date('effective_date')
            ->allowEmptyDate('effective_date');

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
