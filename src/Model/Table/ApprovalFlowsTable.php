<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApprovalFlows Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\ApprovalFlow newEmptyEntity()
 * @method \App\Model\Entity\ApprovalFlow newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalFlow> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalFlow get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ApprovalFlow findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ApprovalFlow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalFlow> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalFlow|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ApprovalFlow saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalFlow>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalFlow>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalFlow>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalFlow> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalFlow>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalFlow>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalFlow>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalFlow> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApprovalFlowsTable extends Table
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

        $this->setTable('approval_flows');
        $this->setDisplayField('module_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
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
            ->scalar('module_name')
            ->maxLength('module_name', 100)
            ->requirePresence('module_name', 'create')
            ->notEmptyString('module_name');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmptyString('level');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

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

        return $rules;
    }
}
