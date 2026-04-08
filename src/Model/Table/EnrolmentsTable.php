<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enrolments Model
 *
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\BelongsTo $Units
 *
 * @method \App\Model\Entity\Enrolment newEmptyEntity()
 * @method \App\Model\Entity\Enrolment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Enrolment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Enrolment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Enrolment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Enrolment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Enrolment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Enrolment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Enrolment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Enrolment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Enrolment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Enrolment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Enrolment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Enrolment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Enrolment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Enrolment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Enrolment> deleteManyOrFail(iterable $entities, array $options = [])
 */
class EnrolmentsTable extends Table
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

        $this->setTable('enrolments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('LeasePayments', [
            'foreignKey' => 'enrolment_id',
        ]);
        $this->hasMany('Levies', [
            'foreignKey' => 'enrolment_id',
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
            ->integer('tenant_id')
            ->notEmptyString('tenant_id');

        $validator
            ->integer('unit_id')
            ->notEmptyString('unit_id');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDateTime('start_date');

        $validator
            ->dateTime('end_date')
            ->allowEmptyDateTime('end_date');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmptyString('rate');

        $validator
            ->scalar('status')
            ->maxLength('status', 151)
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
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'), ['errorField' => 'tenant_id']);
        $rules->add($rules->existsIn(['unit_id'], 'Units'), ['errorField' => 'unit_id']);

        return $rules;
    }
}
