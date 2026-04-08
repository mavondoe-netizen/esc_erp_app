<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeasePayments Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\EnrolmentsTable&\Cake\ORM\Association\BelongsTo $Enrolments
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\BelongsTo $Units
 * @property \App\Model\Table\BuildingsTable&\Cake\ORM\Association\BelongsTo $Buildings
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\LeasePayment newEmptyEntity()
 * @method \App\Model\Entity\LeasePayment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LeasePayment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeasePayment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LeasePayment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LeasePayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LeasePayment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeasePayment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LeasePayment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LeasePayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeasePayment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeasePayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeasePayment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeasePayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeasePayment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeasePayment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeasePayment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeasePaymentsTable extends Table
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

        $this->setTable('lease_payments');
        $this->setDisplayField('currency');
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
            ->integer('account_id')
            ->allowEmptyString('account_id');

        $validator
            ->decimal('amount')
            ->notEmptyString('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('payment_mode')
            ->maxLength('payment_mode', 50)
            ->allowEmptyString('payment_mode');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 150)
            ->allowEmptyString('reference');

        $validator
            ->scalar('period_covered')
            ->maxLength('period_covered', 50)
            ->allowEmptyString('period_covered');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

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
