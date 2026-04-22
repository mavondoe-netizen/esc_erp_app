<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetCategories Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\AssetCategory newEmptyEntity()
 * @method \App\Model\Entity\AssetCategory newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetCategory> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetCategory get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetCategory findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetCategory> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetCategory|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetCategory>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetCategory> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetCategory>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetCategory> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetCategoriesTable extends Table
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

        $this->setTable('asset_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('default_useful_life')
            ->allowEmptyString('default_useful_life');

        $validator
            ->scalar('depreciation_method')
            ->maxLength('depreciation_method', 50)
            ->notEmptyString('depreciation_method');

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
