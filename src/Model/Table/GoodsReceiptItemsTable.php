<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GoodsReceiptItems Model
 *
 * @property \App\Model\Table\GoodsReceiptsTable&\Cake\ORM\Association\BelongsTo $GoodsReceipts
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\GoodsReceiptItem newEmptyEntity()
 * @method \App\Model\Entity\GoodsReceiptItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\GoodsReceiptItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GoodsReceiptItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\GoodsReceiptItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\GoodsReceiptItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\GoodsReceiptItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GoodsReceiptItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\GoodsReceiptItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceiptItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceiptItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceiptItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceiptItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceiptItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceiptItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GoodsReceiptItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GoodsReceiptItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GoodsReceiptItemsTable extends Table
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

        $this->setTable('goods_receipt_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('GoodsReceipts', [
            'foreignKey' => 'goods_receipt_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
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
            ->integer('goods_receipt_id')
            ->notEmptyString('goods_receipt_id');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->decimal('quantity_received')
            ->requirePresence('quantity_received', 'create')
            ->notEmptyString('quantity_received');

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
        $rules->add($rules->existsIn(['goods_receipt_id'], 'GoodsReceipts'), ['errorField' => 'goods_receipt_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
