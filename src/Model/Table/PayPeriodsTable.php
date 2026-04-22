<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PayPeriods Model
 *
 * @property \App\Model\Table\PayslipsTable&\Cake\ORM\Association\HasMany $Payslips
 *
 * @method \App\Model\Entity\PayPeriod newEmptyEntity()
 * @method \App\Model\Entity\PayPeriod newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PayPeriod> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PayPeriod get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PayPeriod findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PayPeriod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PayPeriod> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PayPeriod|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PayPeriod saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PayPeriod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayPeriod>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayPeriod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayPeriod> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayPeriod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayPeriod>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayPeriod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayPeriod> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 */
class PayPeriodsTable extends Table
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

        $this->setTable('pay_periods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Payslips', [
            'foreignKey' => 'pay_period_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDate('end_date');

        $validator
            ->scalar('status')
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
