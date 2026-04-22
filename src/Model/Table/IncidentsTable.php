<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Incidents Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\LossEventsTable&\Cake\ORM\Association\HasMany $LossEvents
 *
 * @method \App\Model\Entity\Incident newEmptyEntity()
 * @method \App\Model\Entity\Incident newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Incident> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Incident get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Incident findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Incident patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Incident> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Incident|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Incident saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Incident>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Incident>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Incident>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Incident> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Incident>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Incident>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Incident>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Incident> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IncidentsTable extends Table
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

        $this->setTable('incidents');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('LossEvents', [
            'foreignKey' => 'incident_id',
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('type')
            ->maxLength('type', 100)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->integer('business_unit_id')
            ->allowEmptyString('business_unit_id');

        $validator
            ->integer('reported_by')
            ->allowEmptyString('reported_by');

        $validator
            ->dateTime('reported_at')
            ->allowEmptyDateTime('reported_at');

        $validator
            ->scalar('severity')
            ->maxLength('severity', 50)
            ->allowEmptyString('severity');

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
