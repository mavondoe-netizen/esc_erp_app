<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Levies Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\EnrolmentsTable&\Cake\ORM\Association\BelongsTo $Enrolments
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\BelongsTo $Units
 * @property \App\Model\Table\BuildingsTable&\Cake\ORM\Association\BelongsTo $Buildings
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\LevyItemsTable&\Cake\ORM\Association\HasMany $LevyItems
 *
 * @method \App\Model\Entity\Levy newEmptyEntity()
 * @method \App\Model\Entity\Levy newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Levy> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Levy get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Levy findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Levy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Levy> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Levy|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Levy saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Levy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Levy>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Levy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Levy> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Levy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Levy>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Levy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Levy> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeviesTable extends Table
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

        $this->setTable('levies');
        $this->setDisplayField('levy_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Enrolments', [
            'foreignKey' => 'enrolment_id',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
        ]);
        $this->belongsTo('Buildings', [
            'foreignKey' => 'building_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->hasMany('LevyItems', [
            'foreignKey' => 'levy_id',
            'dependent'  => true,
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
            ->integer('enrolment_id')
            ->allowEmptyString('enrolment_id');

        $validator
            ->integer('tenant_id')
            ->allowEmptyString('tenant_id');

        $validator
            ->integer('unit_id')
            ->allowEmptyString('unit_id');

        $validator
            ->integer('building_id')
            ->allowEmptyString('building_id');

        $validator
            ->scalar('levy_type')
            ->maxLength('levy_type', 100)
            ->notEmptyString('levy_type');

        $validator
            ->decimal('amount')
            ->notEmptyString('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->boolean('paid')
            ->notEmptyString('paid');

        $validator
            ->date('paid_date')
            ->allowEmptyDate('paid_date');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
