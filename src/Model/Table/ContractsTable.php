<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contracts Model
 *
 * @property \App\Model\Table\AwardsTable&\Cake\ORM\Association\BelongsTo $Awards
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\GoodsReceiptsTable&\Cake\ORM\Association\HasMany $GoodsReceipts
 *
 * @method \App\Model\Entity\Contract newEmptyEntity()
 * @method \App\Model\Entity\Contract newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Contract> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contract get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Contract findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Contract patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Contract> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contract|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Contract saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Contract>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Contract>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Contract>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Contract> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Contract>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Contract>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Contract>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Contract> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContractsTable extends Table
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

        $this->setTable('contracts');
        $this->setDisplayField('contract_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Awards', [
            'foreignKey' => 'award_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('GoodsReceipts', [
            'foreignKey' => 'contract_id',
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
            ->integer('award_id')
            ->notEmptyString('award_id');

        $validator
            ->scalar('contract_number')
            ->maxLength('contract_number', 100)
            ->requirePresence('contract_number', 'create')
            ->notEmptyString('contract_number')
            ->add('contract_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->scalar('sla_terms')
            ->allowEmptyString('sla_terms');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

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
        $rules->add($rules->isUnique(['contract_number']), ['errorField' => 'contract_number']);
        $rules->add($rules->existsIn(['award_id'], 'Awards'), ['errorField' => 'award_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
