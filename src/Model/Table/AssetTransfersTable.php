<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetTransfers Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\BelongsTo $Assets
 *
 * @method \App\Model\Entity\AssetTransfer newEmptyEntity()
 * @method \App\Model\Entity\AssetTransfer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetTransfer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetTransfer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetTransfer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetTransfer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetTransfer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetTransfer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetTransfer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetTransfer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetTransfer>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetTransfer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetTransfer> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetTransfer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetTransfer>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetTransfer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetTransfer> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetTransfersTable extends Table
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

        $this->setTable('asset_transfers');
        $this->setDisplayField('status');
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
            ->integer('from_office_id')
            ->allowEmptyString('from_office_id');

        $validator
            ->integer('to_office_id')
            ->allowEmptyString('to_office_id');

        $validator
            ->date('transfer_date')
            ->requirePresence('transfer_date', 'create')
            ->notEmptyDate('transfer_date');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

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
