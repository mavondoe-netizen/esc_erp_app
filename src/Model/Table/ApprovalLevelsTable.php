<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApprovalLevels Model
 *
 * @method \App\Model\Entity\ApprovalLevel newEmptyEntity()
 * @method \App\Model\Entity\ApprovalLevel newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalLevel> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalLevel get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ApprovalLevel findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ApprovalLevel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalLevel> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalLevel|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ApprovalLevel saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalLevel>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalLevel>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalLevel>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalLevel> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalLevel>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalLevel>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalLevel>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalLevel> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApprovalLevelsTable extends Table
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

        $this->setTable('approval_levels');
        $this->setDisplayField('entity');
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
            ->scalar('entity')
            ->maxLength('entity', 100)
            ->requirePresence('entity', 'create')
            ->notEmptyString('entity');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmptyString('level');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->decimal('min_value')
            ->allowEmptyString('min_value');

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
