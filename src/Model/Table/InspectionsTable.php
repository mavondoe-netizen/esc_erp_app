<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inspections Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\InspectorsTable&\Cake\ORM\Association\BelongsTo $Inspectors
 *
 * @method \App\Model\Entity\Inspection newEmptyEntity()
 * @method \App\Model\Entity\Inspection newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inspection get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Inspection findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Inspection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inspection|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Inspection saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InspectionsTable extends Table
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

        $this->setTable('inspections');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Inspectors', [
            'foreignKey' => 'inspector_id',
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
            ->scalar('name')
            ->maxLength('name', 151)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->numeric('pobs_insurable')
            ->requirePresence('pobs_insurable', 'create')
            ->notEmptyString('pobs_insurable');

        $validator
            ->numeric('apwcs_insurable')
            ->requirePresence('apwcs_insurable', 'create')
            ->notEmptyString('apwcs_insurable');

        $validator
            ->numeric('apwcs_penalty')
            ->requirePresence('apwcs_penalty', 'create')
            ->notEmptyString('apwcs_penalty');

        $validator
            ->integer('inspector_id')
            ->notEmptyString('inspector_id');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['inspector_id'], 'Inspectors'), ['errorField' => 'inspector_id']);

        return $rules;
    }
}
