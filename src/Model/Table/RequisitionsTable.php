<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Requisitions Model
 *
 * @property \App\Model\Table\DepartmentsTable&\Cake\ORM\Association\BelongsTo $Departments
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ProcurementsTable&\Cake\ORM\Association\HasMany $Procurements
 * @property \App\Model\Table\RequisitionItemsTable&\Cake\ORM\Association\HasMany $RequisitionItems
 *
 * @method \App\Model\Entity\Requisition newEmptyEntity()
 * @method \App\Model\Entity\Requisition newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Requisition> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Requisition get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Requisition findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Requisition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Requisition> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Requisition|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Requisition saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Requisition>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Requisition> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RequisitionsTable extends Table
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

        $this->setTable('requisitions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Procurements', [
            'foreignKey' => 'requisition_id',
        ]);
        $this->hasMany('RequisitionItems', [
            'foreignKey' => 'requisition_id',
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
            ->integer('department_id')
            ->notEmptyString('department_id');

        $validator
            ->integer('requested_by')
            ->requirePresence('requested_by', 'create')
            ->notEmptyString('requested_by');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->decimal('total_estimated_cost')
            ->allowEmptyString('total_estimated_cost');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->scalar('manual_reference')
            ->maxLength('manual_reference', 100)
            ->allowEmptyString('manual_reference');

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
        $rules->add($rules->existsIn(['department_id'], 'Departments'), ['errorField' => 'department_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
