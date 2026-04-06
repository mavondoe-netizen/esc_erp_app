<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deductions Model
 *
 * @method \App\Model\Entity\Deduction newEmptyEntity()
 * @method \App\Model\Entity\Deduction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Deduction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Deduction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Deduction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Deduction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Deduction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Deduction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Deduction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Deduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deduction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deduction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deduction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deduction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deduction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DeductionsTable extends Table
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

        $this->setTable('deductions');
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
            ->boolean('statutory')
            ->requirePresence('statutory', 'create')
            ->notEmptyString('statutory');

        $validator
            ->boolean('tax_deductible')
            ->requirePresence('tax_deductible', 'create')
            ->notEmptyString('tax_deductible');

        $validator
            ->scalar('calculation_type')
            ->maxLength('calculation_type', 151)
            ->requirePresence('calculation_type', 'create')
            ->notEmptyString('calculation_type');
            
        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

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
