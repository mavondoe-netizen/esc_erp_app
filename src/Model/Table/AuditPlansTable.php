<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuditPlans Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 *
 * @method \App\Model\Entity\AuditPlan newEmptyEntity()
 * @method \App\Model\Entity\AuditPlan newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditPlan> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditPlan get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AuditPlan findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AuditPlan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditPlan> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditPlan|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AuditPlan saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AuditPlan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditPlan>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditPlan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditPlan> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditPlan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditPlan>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditPlan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditPlan> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditPlansTable extends Table
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

        $this->setTable('audit_plans');
        $this->setDisplayField('audit_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Audits', [
            'foreignKey' => 'audit_plan_id',
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
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year');

        $validator
            ->integer('business_unit_id')
            ->allowEmptyString('business_unit_id');

        $validator
            ->scalar('audit_type')
            ->maxLength('audit_type', 100)
            ->requirePresence('audit_type', 'create')
            ->notEmptyString('audit_type');

        $validator
            ->date('planned_start')
            ->allowEmptyDate('planned_start');

        $validator
            ->date('planned_end')
            ->allowEmptyDate('planned_end');

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
