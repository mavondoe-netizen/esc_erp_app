<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Controls Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\RisksTable&\Cake\ORM\Association\BelongsTo $Risks
 * @property \App\Model\Table\ControlTestsTable&\Cake\ORM\Association\HasMany $ControlTests
 *
 * @method \App\Model\Entity\Control newEmptyEntity()
 * @method \App\Model\Entity\Control newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Control> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Control get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Control findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Control patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Control> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Control|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Control saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Control>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Control>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Control>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Control> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Control>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Control>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Control>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Control> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ControlsTable extends Table
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

        $this->setTable('controls');
        $this->setDisplayField('control_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Risks', [
            'foreignKey' => 'risk_id',
        ]);
        $this->hasMany('ControlTests', [
            'foreignKey' => 'control_id',
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
            ->integer('risk_id')
            ->allowEmptyString('risk_id');

        $validator
            ->scalar('control_name')
            ->maxLength('control_name', 255)
            ->requirePresence('control_name', 'create')
            ->notEmptyString('control_name');

        $validator
            ->scalar('control_type')
            ->maxLength('control_type', 100)
            ->allowEmptyString('control_type');

        $validator
            ->scalar('frequency')
            ->maxLength('frequency', 100)
            ->allowEmptyString('frequency');

        $validator
            ->integer('owner_id')
            ->allowEmptyString('owner_id');

        $validator
            ->scalar('effectiveness_rating')
            ->maxLength('effectiveness_rating', 100)
            ->allowEmptyString('effectiveness_rating');

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
        $rules->add($rules->existsIn(['risk_id'], 'Risks'), ['errorField' => 'risk_id']);

        return $rules;
    }
}
