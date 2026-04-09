<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetDepreciation Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\BelongsTo $Assets
 *
 * @method \App\Model\Entity\AssetDepreciation newEmptyEntity()
 * @method \App\Model\Entity\AssetDepreciation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetDepreciation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetDepreciation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetDepreciation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetDepreciation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetDepreciation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetDepreciation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetDepreciation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDepreciation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDepreciation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDepreciation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDepreciation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDepreciation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDepreciation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDepreciation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDepreciation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetDepreciationTable extends Table
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

        $this->setTable('asset_depreciation');
        $this->setDisplayField('period');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id',
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
            ->integer('asset_id')
            ->notEmptyString('asset_id');

        $validator
            ->scalar('period')
            ->maxLength('period', 10)
            ->requirePresence('period', 'create')
            ->notEmptyString('period');

        $validator
            ->decimal('depreciation_amount')
            ->requirePresence('depreciation_amount', 'create')
            ->notEmptyString('depreciation_amount');

        $validator
            ->decimal('accumulated_depreciation')
            ->requirePresence('accumulated_depreciation', 'create')
            ->notEmptyString('accumulated_depreciation');

        $validator
            ->decimal('book_value')
            ->requirePresence('book_value', 'create')
            ->notEmptyString('book_value');

        $validator
            ->boolean('posted_to_ledger')
            ->notEmptyString('posted_to_ledger');

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
        $rules->add($rules->existsIn(['asset_id'], 'Assets'), ['errorField' => 'asset_id']);

        return $rules;
    }
}
