<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsReceipts Model
 *
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\BelongsTo $Contracts
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\GoodsReceiptItemsTable&\Cake\ORM\Association\HasMany $GoodsReceiptItems
 *
 * @method \App\Model\Entity\GoodsReceipt newEmptyEntity()
 * @method \App\Model\Entity\GoodsReceipt newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\GoodsReceipt> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsReceipt get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\GoodsReceipt findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\GoodsReceipt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\GoodsReceipt> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsReceipt|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\GoodsReceipt saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceipt>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceipt> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceipt>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceipt> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsReceiptsTable extends Table
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

        $this->setTable('goods_receipts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Contracts', [
            'foreignKey' => 'contract_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'received_by',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('GoodsReceiptItems', [
            'foreignKey' => 'goods_receipt_id',
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
            ->integer('contract_id')
            ->notEmptyString('contract_id');

        $validator
            ->integer('received_by')
            ->requirePresence('received_by', 'create')
            ->notEmptyString('received_by');

        $validator
            ->dateTime('received_date')
            ->requirePresence('received_date', 'create')
            ->notEmptyDateTime('received_date');

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
        $rules->add($rules->existsIn(['contract_id'], 'Contracts'), ['errorField' => 'contract_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
