<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Procurements Model
 *
 * @property \App\Model\Table\RequisitionsTable&\Cake\ORM\Association\BelongsTo $Requisitions
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\TendersTable&\Cake\ORM\Association\HasMany $Tenders
 *
 * @method \App\Model\Entity\Procurement newEmptyEntity()
 * @method \App\Model\Entity\Procurement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Procurement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Procurement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Procurement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Procurement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Procurement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Procurement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Procurement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Procurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Procurement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Procurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Procurement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Procurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Procurement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Procurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Procurement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProcurementsTable extends Table
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

        $this->setTable('procurements');
        $this->setDisplayField('procurement_method');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Requisitions', [
            'foreignKey' => 'requisition_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'assigned_to',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Tenders', [
            'foreignKey' => 'procurement_id',
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
            ->integer('requisition_id')
            ->notEmptyString('requisition_id');

        $validator
            ->scalar('procurement_method')
            ->maxLength('procurement_method', 50)
            ->requirePresence('procurement_method', 'create')
            ->notEmptyString('procurement_method');

        $validator
            ->integer('assigned_to')
            ->allowEmptyString('assigned_to');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['requisition_id'], 'Requisitions'), ['errorField' => 'requisition_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
