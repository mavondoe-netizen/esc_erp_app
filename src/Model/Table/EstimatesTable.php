<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estimates Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\EstimateItemsTable&\Cake\ORM\Association\HasMany $EstimateItems
 *
 * @method \App\Model\Entity\Estimate newEmptyEntity()
 * @method \App\Model\Entity\Estimate newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Estimate> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estimate get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Estimate findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Estimate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Estimate> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estimate|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Estimate saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Estimate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estimate>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estimate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estimate> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estimate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estimate>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Estimate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Estimate> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EstimatesTable extends Table
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

        $this->setTable('estimates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');
        $this->addBehavior('AuditLog');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('EstimateItems', [
            'foreignKey' => 'estimate_id',
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
            ->allowEmptyString('company_id');

        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->date('expiry_date')
            ->allowEmptyDate('expiry_date');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->decimal('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
