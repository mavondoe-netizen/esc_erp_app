<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetRepairs Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\BelongsTo $Assets
 *
 * @method \App\Model\Entity\AssetRepair newEmptyEntity()
 * @method \App\Model\Entity\AssetRepair newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetRepair> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetRepair get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetRepair findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetRepair patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetRepair> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetRepair|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetRepair saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetRepair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetRepair>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetRepair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetRepair> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetRepair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetRepair>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetRepair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetRepair> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetRepairsTable extends Table
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

        $this->setTable('asset_repairs');
        $this->setDisplayField('repair_type');
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
            ->scalar('issue_description')
            ->requirePresence('issue_description', 'create')
            ->notEmptyString('issue_description');

        $validator
            ->scalar('repair_type')
            ->maxLength('repair_type', 50)
            ->notEmptyString('repair_type');

        $validator
            ->scalar('vendor')
            ->maxLength('vendor', 255)
            ->allowEmptyString('vendor');

        $validator
            ->decimal('cost')
            ->notEmptyString('cost');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

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
