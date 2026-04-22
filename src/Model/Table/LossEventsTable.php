<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LossEvents Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\IncidentsTable&\Cake\ORM\Association\BelongsTo $Incidents
 *
 * @method \App\Model\Entity\LossEvent newEmptyEntity()
 * @method \App\Model\Entity\LossEvent newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LossEvent> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LossEvent get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LossEvent findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LossEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LossEvent> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LossEvent|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LossEvent saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LossEvent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LossEvent>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LossEvent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LossEvent> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LossEvent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LossEvent>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LossEvent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LossEvent> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LossEventsTable extends Table
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

        $this->setTable('loss_events');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Incidents', [
            'foreignKey' => 'incident_id',
            'joinType' => 'INNER',
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
            ->integer('incident_id')
            ->notEmptyString('incident_id');

        $validator
            ->decimal('amount')
            ->notEmptyString('amount');

        $validator
            ->decimal('recovery_amount')
            ->allowEmptyString('recovery_amount');

        $validator
            ->decimal('net_loss')
            ->allowEmptyString('net_loss');

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
        $rules->add($rules->existsIn(['incident_id'], 'Incidents'), ['errorField' => 'incident_id']);

        return $rules;
    }
}
