<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Repairs Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\BelongsTo $Units
 * @property \App\Model\Table\BuildingsTable&\Cake\ORM\Association\BelongsTo $Buildings
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\Repair newEmptyEntity()
 * @method \App\Model\Entity\Repair newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Repair> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Repair get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Repair findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Repair patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Repair> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Repair|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Repair saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Repair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Repair>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Repair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Repair> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Repair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Repair>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Repair>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Repair> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RepairsTable extends Table
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

        $this->setTable('repairs');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
        ]);
        $this->belongsTo('Buildings', [
            'foreignKey' => 'building_id',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->integer('unit_id')
            ->allowEmptyString('unit_id');

        $validator
            ->integer('building_id')
            ->allowEmptyString('building_id');

        $validator
            ->integer('tenant_id')
            ->allowEmptyString('tenant_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->allowEmptyString('category');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        $validator
            ->date('reported_date')
            ->allowEmptyDate('reported_date');

        $validator
            ->date('resolved_date')
            ->allowEmptyDate('resolved_date');

        $validator
            ->decimal('cost')
            ->allowEmptyString('cost');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->allowEmptyString('currency');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

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
        return $rules;
    }
}
