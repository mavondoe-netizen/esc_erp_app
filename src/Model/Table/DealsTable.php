<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Deals Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\ContactsTable&\Cake\ORM\Association\BelongsTo $Contacts
 *
 * @method \App\Model\Entity\Deal newEmptyEntity()
 * @method \App\Model\Entity\Deal newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Deal> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Deal get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Deal findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Deal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Deal> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Deal|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Deal saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Deal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deal>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deal> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deal>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Deal>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Deal> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DealsTable extends Table
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

        $this->setTable('deals');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
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
            ->maxLength('name', 151)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 151)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('type')
            ->maxLength('type', 151)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->decimal('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->scalar('stage')
            ->maxLength('stage', 151)
            ->requirePresence('stage', 'create')
            ->notEmptyString('stage');

        $validator
            ->integer('contact_id')
            ->allowEmptyString('contact_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 151)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->integer('submitted_by')
            ->allowEmptyString('submitted_by');

        $validator
            ->dateTime('submitted_at')
            ->allowEmptyDateTime('submitted_at');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

        $validator
            ->integer('rejected_by')
            ->allowEmptyString('rejected_by');

        $validator
            ->dateTime('rejected_at')
            ->allowEmptyDateTime('rejected_at');

        $validator
            ->scalar('rejection_reason')
            ->allowEmptyString('rejection_reason');

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
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'), ['errorField' => 'contact_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
