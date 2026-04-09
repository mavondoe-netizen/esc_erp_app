<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssetAssignments Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\BelongsTo $Assets
 * @property \App\Model\Table\OfficesTable&\Cake\ORM\Association\BelongsTo $Offices
 * @property \App\Model\Table\DepartmentsTable&\Cake\ORM\Association\BelongsTo $Departments
 *
 * @method \App\Model\Entity\AssetAssignment newEmptyEntity()
 * @method \App\Model\Entity\AssetAssignment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetAssignment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssetAssignment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AssetAssignment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AssetAssignment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AssetAssignment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssetAssignment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AssetAssignment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AssetAssignment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetAssignment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetAssignment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetAssignment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetAssignment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetAssignment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AssetAssignment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AssetAssignment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetAssignmentsTable extends Table
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

        $this->setTable('asset_assignments');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
        ]);
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
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
            ->notEmptyString('company_id');

        $validator
            ->integer('asset_id')
            ->notEmptyString('asset_id');

        $validator
            ->integer('office_id')
            ->allowEmptyString('office_id');

        $validator
            ->integer('department_id')
            ->allowEmptyString('department_id');

        $validator
            ->integer('assigned_to')
            ->allowEmptyString('assigned_to');

        $validator
            ->date('assigned_date')
            ->requirePresence('assigned_date', 'create')
            ->notEmptyDate('assigned_date');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['asset_id'], 'Assets'), ['errorField' => 'asset_id']);
        $rules->add($rules->existsIn(['office_id'], 'Offices'), ['errorField' => 'office_id']);
        $rules->add($rules->existsIn(['department_id'], 'Departments'), ['errorField' => 'department_id']);

        return $rules;
    }
}
