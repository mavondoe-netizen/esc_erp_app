<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetDisposals Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\BelongsTo $Assets
 *
 * @method \App\Model\Entity\AssetDisposal newEmptyEntity()
 * @method \App\Model\Entity\AssetDisposal newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetDisposal> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetDisposal get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetDisposal findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetDisposal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetDisposal> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetDisposal|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetDisposal saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDisposal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDisposal>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDisposal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDisposal> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDisposal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDisposal>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetDisposal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetDisposal> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetDisposalsTable extends Table
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

        $this->setTable('asset_disposals');
        $this->setDisplayField('disposal_type');
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
            ->scalar('disposal_type')
            ->maxLength('disposal_type', 50)
            ->requirePresence('disposal_type', 'create')
            ->notEmptyString('disposal_type');

        $validator
            ->date('disposal_date')
            ->requirePresence('disposal_date', 'create')
            ->notEmptyDate('disposal_date');

        $validator
            ->decimal('disposal_amount')
            ->notEmptyString('disposal_amount');

        $validator
            ->decimal('gain_or_loss')
            ->allowEmptyString('gain_or_loss');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

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
