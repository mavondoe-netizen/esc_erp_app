<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \App\Model\Table\ApprovalFlowsTable&\Cake\ORM\Association\HasMany $ApprovalFlows
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Role newEmptyEntity()
 * @method \App\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Role findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolesTable extends Table
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

        $this->setTable('roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('ApprovalFlows', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('Permissions', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('SalaryStructures', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'role_id',
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
