<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenderBids Model
 *
 * @property \App\Model\Table\TendersTable&\Cake\ORM\Association\BelongsTo $Tenders
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\TenderBid newEmptyEntity()
 * @method \App\Model\Entity\TenderBid newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TenderBid> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TenderBid get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TenderBid findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TenderBid patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TenderBid> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TenderBid|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TenderBid saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TenderBid>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TenderBid>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TenderBid>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TenderBid> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TenderBid>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TenderBid>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TenderBid>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TenderBid> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenderBidsTable extends Table
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

        $this->setTable('tender_bids');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Tenders', [
            'foreignKey' => 'tender_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
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
            ->integer('tender_id')
            ->notEmptyString('tender_id');

        $validator
            ->integer('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->decimal('bid_amount')
            ->requirePresence('bid_amount', 'create')
            ->notEmptyString('bid_amount');

        $validator
            ->decimal('technical_score')
            ->allowEmptyString('technical_score');

        $validator
            ->decimal('financial_score')
            ->allowEmptyString('financial_score');

        $validator
            ->decimal('total_score')
            ->allowEmptyString('total_score');

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
        $rules->add($rules->existsIn(['tender_id'], 'Tenders'), ['errorField' => 'tender_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
