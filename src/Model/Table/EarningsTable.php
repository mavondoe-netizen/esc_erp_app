<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Earnings Model
 *
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\Earning newEmptyEntity()
 * @method \App\Model\Entity\Earning newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Earning> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Earning get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Earning findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Earning patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Earning> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Earning|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Earning saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Earning>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Earning>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Earning>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Earning> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Earning>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Earning>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Earning>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Earning> deleteManyOrFail(iterable $entities, array $options = [])
 */
class EarningsTable extends Table
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

        $this->addBehavior('TenantAware');

        $this->setTable('earnings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->scalar('name')
            ->maxLength('name', 151)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->boolean('taxable')
            ->requirePresence('taxable', 'create')
            ->notEmptyString('taxable');

        $validator
            ->boolean('pensionable')
            ->requirePresence('pensionable', 'create')
            ->notEmptyString('pensionable');

        $validator
            ->boolean('nssa_applicable')
            ->requirePresence('nssa_applicable', 'create')
            ->notEmptyString('nssa_applicable');

        $validator
            ->scalar('calculation_type')
            ->maxLength('calculation_type', 151)
            ->requirePresence('calculation_type', 'create')
            ->notEmptyString('calculation_type');

        $validator
            ->boolean('gross_up')
            ->allowEmptyString('gross_up');

        $validator
            ->decimal('taxable_percentage')
            ->allowEmptyString('taxable_percentage');

        $validator
            ->decimal('tax_free_amount')
            ->allowEmptyString('tax_free_amount');

        $validator
            ->scalar('zimra_mapping')
            ->maxLength('zimra_mapping', 255)
            ->allowEmptyString('zimra_mapping');

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

        return $rules;
    }
}
