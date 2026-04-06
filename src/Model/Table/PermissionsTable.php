<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permissions Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\Permission newEmptyEntity()
 * @method \App\Model\Entity\Permission newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Permission> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Permission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Permission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Permission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Permission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Permission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Permission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Permission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Permission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Permission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Permission> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PermissionsTable extends Table
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

        $this->setTable('permissions');
        $this->setDisplayField('model');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
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
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('model')
            ->maxLength('model', 100)
            ->requirePresence('model', 'create')
            ->notEmptyString('model');

        $validator
            ->boolean('can_create')
            ->allowEmptyString('can_create');

        $validator
            ->boolean('can_read')
            ->allowEmptyString('can_read');

        $validator
            ->boolean('can_update')
            ->allowEmptyString('can_update');

        $validator
            ->boolean('can_delete')
            ->allowEmptyString('can_delete');

        $validator
            ->boolean('can_approve')
            ->allowEmptyString('can_approve');

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
