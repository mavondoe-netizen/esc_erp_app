<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalaryStructures Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\PayrollRecordsTable&\Cake\ORM\Association\HasMany $PayrollRecords
 *
 * @method \App\Model\Entity\SalaryStructure newEmptyEntity()
 * @method \App\Model\Entity\SalaryStructure newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SalaryStructure> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalaryStructure get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SalaryStructure findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SalaryStructure patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SalaryStructure> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalaryStructure|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SalaryStructure saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SalaryStructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalaryStructure>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalaryStructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalaryStructure> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalaryStructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalaryStructure>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalaryStructure>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalaryStructure> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalaryStructuresTable extends Table
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

        $this->setTable('salary_structures');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('PayrollRecords', [
            'foreignKey' => 'salary_structure_id',
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
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->integer('role_id')
            ->allowEmptyString('role_id');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 3)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->decimal('basic_salary')
            ->requirePresence('basic_salary', 'create')
            ->notEmptyString('basic_salary');

        $validator
            ->scalar('payment_frequency')
            ->maxLength('payment_frequency', 50)
            ->allowEmptyString('payment_frequency');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
