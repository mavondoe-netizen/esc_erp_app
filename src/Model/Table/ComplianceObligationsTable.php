<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComplianceObligations Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\RegulationsTable&\Cake\ORM\Association\BelongsTo $Regulations
 *
 * @method \App\Model\Entity\ComplianceObligation newEmptyEntity()
 * @method \App\Model\Entity\ComplianceObligation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ComplianceObligation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComplianceObligation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ComplianceObligation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ComplianceObligation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ComplianceObligation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComplianceObligation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ComplianceObligation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceObligation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceObligation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceObligation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceObligation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceObligation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceObligation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceObligation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceObligation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ComplianceObligationsTable extends Table
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

        $this->setTable('compliance_obligations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Regulations', [
            'foreignKey' => 'regulation_id',
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
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->integer('regulation_id')
            ->notEmptyString('regulation_id');

        $validator
            ->scalar('requirement')
            ->requirePresence('requirement', 'create')
            ->notEmptyString('requirement');

        $validator
            ->scalar('frequency')
            ->maxLength('frequency', 100)
            ->allowEmptyString('frequency');

        $validator
            ->integer('owner_id')
            ->allowEmptyString('owner_id');

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
        $rules->add($rules->existsIn(['regulation_id'], 'Regulations'), ['errorField' => 'regulation_id']);

        return $rules;
    }
}
