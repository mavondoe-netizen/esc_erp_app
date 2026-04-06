<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApprovalHistories Model
 *
 * @property \App\Model\Table\ApprovalsTable&\Cake\ORM\Association\BelongsTo $Approvals
 *
 * @method \App\Model\Entity\ApprovalHistory newEmptyEntity()
 * @method \App\Model\Entity\ApprovalHistory newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalHistory> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalHistory get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ApprovalHistory findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ApprovalHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ApprovalHistory> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovalHistory|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ApprovalHistory saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalHistory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalHistory>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalHistory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalHistory> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalHistory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalHistory>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ApprovalHistory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ApprovalHistory> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApprovalHistoriesTable extends Table
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

        $this->setTable('approval_histories');
        $this->setDisplayField('action');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Approvals', [
            'foreignKey' => 'approval_id',
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
            ->integer('approval_id')
            ->notEmptyString('approval_id');

        $validator
            ->scalar('action')
            ->requirePresence('action', 'create')
            ->notEmptyString('action');

        $validator
            ->integer('level')
            ->allowEmptyString('level');

        $validator
            ->integer('performed_by')
            ->allowEmptyString('performed_by');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

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
        $rules->add($rules->existsIn(['approval_id'], 'Approvals'), ['errorField' => 'approval_id']);

        return $rules;
    }
}
