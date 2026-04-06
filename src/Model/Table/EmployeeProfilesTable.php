<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeProfiles Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EmployeeProfile newEmptyEntity()
 * @method \App\Model\Entity\EmployeeProfile newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EmployeeProfile> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeProfile get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EmployeeProfile findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EmployeeProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EmployeeProfile> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeProfile|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EmployeeProfile saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EmployeeProfile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmployeeProfile>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmployeeProfile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmployeeProfile> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmployeeProfile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmployeeProfile>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmployeeProfile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmployeeProfile> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeProfilesTable extends Table
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

        $this->setTable('employee_profiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id')
            ->add('user_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('employee_id_number')
            ->maxLength('employee_id_number', 100)
            ->allowEmptyString('employee_id_number');

        $validator
            ->scalar('tax_number')
            ->maxLength('tax_number', 100)
            ->allowEmptyString('tax_number');

        $validator
            ->scalar('social_security_number')
            ->maxLength('social_security_number', 100)
            ->allowEmptyString('social_security_number');

        $validator
            ->date('hire_date')
            ->allowEmptyDate('hire_date');

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
        $rules->add($rules->isUnique(['user_id']), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
