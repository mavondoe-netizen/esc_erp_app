<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Assets Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\OfficesTable&\Cake\ORM\Association\BelongsTo $Offices
 * @property \App\Model\Table\AssetAssignmentsTable&\Cake\ORM\Association\HasMany $AssetAssignments
 * @property \App\Model\Table\AssetDepreciationTable&\Cake\ORM\Association\HasMany $AssetDepreciation
 * @property \App\Model\Table\AssetDisposalsTable&\Cake\ORM\Association\HasMany $AssetDisposals
 * @property \App\Model\Table\AssetLogsTable&\Cake\ORM\Association\HasMany $AssetLogs
 * @property \App\Model\Table\AssetRepairsTable&\Cake\ORM\Association\HasMany $AssetRepairs
 * @property \App\Model\Table\AssetTransfersTable&\Cake\ORM\Association\HasMany $AssetTransfers
 *
 * @method \App\Model\Entity\Asset newEmptyEntity()
 * @method \App\Model\Entity\Asset newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Asset> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Asset get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Asset findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Asset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Asset> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Asset|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Asset saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Asset>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Asset>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Asset>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Asset> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Asset>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Asset>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Asset>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Asset> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetsTable extends Table
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

        $this->setTable('assets');
        $this->setDisplayField('asset_tag');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
        ]);
        $this->hasMany('AssetAssignments', [
            'foreignKey' => 'asset_id',
        ]);
        $this->hasMany('AssetDepreciation', [
            'foreignKey' => 'asset_id',
        ]);
        $this->hasMany('AssetDisposals', [
            'foreignKey' => 'asset_id',
        ]);
        $this->hasMany('AssetLogs', [
            'foreignKey' => 'asset_id',
        ]);
        $this->hasMany('AssetRepairs', [
            'foreignKey' => 'asset_id',
        ]);
        $this->hasMany('AssetTransfers', [
            'foreignKey' => 'asset_id',
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
            ->scalar('asset_tag')
            ->maxLength('asset_tag', 100)
            ->requirePresence('asset_tag', 'create')
            ->notEmptyString('asset_tag');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('category_id')
            ->allowEmptyString('category_id');

        $validator
            ->integer('classification_id')
            ->allowEmptyString('classification_id');

        $validator
            ->date('acquisition_date')
            ->allowEmptyDate('acquisition_date');

        $validator
            ->decimal('acquisition_cost')
            ->allowEmptyString('acquisition_cost');

        $validator
            ->integer('useful_life')
            ->allowEmptyString('useful_life');

        $validator
            ->scalar('depreciation_method')
            ->maxLength('depreciation_method', 50)
            ->notEmptyString('depreciation_method');

        $validator
            ->decimal('residual_value')
            ->notEmptyString('residual_value');

        $validator
            ->decimal('current_book_value')
            ->allowEmptyString('current_book_value');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        $validator
            ->integer('office_id')
            ->allowEmptyString('office_id');

        $validator
            ->integer('assigned_to')
            ->allowEmptyString('assigned_to');

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
        $rules->add($rules->isUnique(['asset_tag', 'company_id']), ['errorField' => 'asset_tag']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['office_id'], 'Offices'), ['errorField' => 'office_id']);

        return $rules;
    }
}
