<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bills Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\BelongsToMany $Transactions
 *
 * @method \App\Model\Entity\Bill newEmptyEntity()
 * @method \App\Model\Entity\Bill newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Bill> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bill get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Bill findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Bill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Bill> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bill|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Bill saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Bill>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Bill>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Bill>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Bill> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Bill>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Bill>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Bill>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Bill> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BillsTable extends Table
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

        $this->setTable('bills');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('BillItems', [
            'foreignKey' => 'bill_id',
        ]);
        $this->belongsToMany('Transactions', [
            'foreignKey' => 'bill_id',
            'targetForeignKey' => 'transaction_id',
            'joinTable' => 'bills_transactions',
        ]);
         $this->hasMany('Accounts', [
            'foreignKey' => 'account_id',
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
            ->integer('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->integer('tenant_id')
            ->allowEmptyString('tenant_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('description')
            ->maxLength('description', 151)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 151)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total');

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
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'), ['errorField' => 'tenant_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
