<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequisitionItems Model
 *
 * @property \App\Model\Table\RequisitionsTable&\Cake\ORM\Association\BelongsTo $Requisitions
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\RequisitionItem newEmptyEntity()
 * @method \App\Model\Entity\RequisitionItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RequisitionItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RequisitionItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RequisitionItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RequisitionItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequisitionItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RequisitionItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RequisitionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RequisitionItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RequisitionItemsTable extends Table
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

        $this->setTable('requisition_items');
        $this->setDisplayField('item_description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Requisitions', [
            'foreignKey' => 'requisition_id',
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
            ->integer('requisition_id')
            ->notEmptyString('requisition_id');

        $validator
            ->scalar('item_description')
            ->maxLength('item_description', 255)
            ->requirePresence('item_description', 'create')
            ->notEmptyString('item_description');

        $validator
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->decimal('estimated_unit_price')
            ->requirePresence('estimated_unit_price', 'create')
            ->notEmptyString('estimated_unit_price');

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
        $rules->add($rules->existsIn(['requisition_id'], 'Requisitions'), ['errorField' => 'requisition_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
