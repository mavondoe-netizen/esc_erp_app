<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Budgets Model
 *
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\Budget newEmptyEntity()
 * @method \App\Model\Entity\Budget newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Budget> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Budget get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Budget findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Budget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Budget> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Budget|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Budget saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BudgetsTable extends Table
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

        $this->setTable('budgets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
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
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDate('end_date');

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
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
