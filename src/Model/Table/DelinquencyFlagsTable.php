<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DelinquencyFlags Model
 *
 * @property \App\Model\Table\LoansTable&\Cake\ORM\Association\BelongsTo $Loans
 *
 * @method \App\Model\Entity\DelinquencyFlag newEmptyEntity()
 * @method \App\Model\Entity\DelinquencyFlag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DelinquencyFlag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DelinquencyFlag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DelinquencyFlag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DelinquencyFlag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DelinquencyFlag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DelinquencyFlag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DelinquencyFlag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DelinquencyFlag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DelinquencyFlag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DelinquencyFlag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DelinquencyFlag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DelinquencyFlag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DelinquencyFlag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DelinquencyFlag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DelinquencyFlag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DelinquencyFlagsTable extends Table
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

        $this->setTable('delinquency_flags');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Loans', [
            'foreignKey' => 'loan_id',
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
            ->integer('loan_id')
            ->notEmptyString('loan_id');

        $validator
            ->integer('days_overdue')
            ->notEmptyString('days_overdue');

        $validator
            ->decimal('amount_overdue')
            ->notEmptyString('amount_overdue');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('category')
            ->maxLength('category', 20)
            ->notEmptyString('category');

        $validator
            ->dateTime('flagged_at')
            ->allowEmptyDateTime('flagged_at');

        $validator
            ->dateTime('resolved_at')
            ->allowEmptyDateTime('resolved_at');

        $validator
            ->boolean('notification_sent')
            ->notEmptyString('notification_sent');

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

        return $rules;
    }
}
