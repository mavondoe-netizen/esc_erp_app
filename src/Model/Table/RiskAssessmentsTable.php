<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RiskAssessments Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\RisksTable&\Cake\ORM\Association\BelongsTo $Risks
 *
 * @method \App\Model\Entity\RiskAssessment newEmptyEntity()
 * @method \App\Model\Entity\RiskAssessment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RiskAssessment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RiskAssessment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RiskAssessment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RiskAssessment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RiskAssessment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RiskAssessment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RiskAssessment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RiskAssessment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RiskAssessment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RiskAssessment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RiskAssessment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RiskAssessment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RiskAssessment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RiskAssessment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RiskAssessment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RiskAssessmentsTable extends Table
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

        $this->setTable('risk_assessments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Risks', [
            'foreignKey' => 'risk_id',
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
            ->integer('risk_id')
            ->notEmptyString('risk_id');

        $validator
            ->integer('likelihood')
            ->requirePresence('likelihood', 'create')
            ->notEmptyString('likelihood');

        $validator
            ->integer('impact')
            ->requirePresence('impact', 'create')
            ->notEmptyString('impact');

        $validator
            ->integer('control_effectiveness')
            ->requirePresence('control_effectiveness', 'create')
            ->notEmptyString('control_effectiveness');

        $validator
            ->decimal('risk_rating')
            ->requirePresence('risk_rating', 'create')
            ->notEmptyString('risk_rating');

        $validator
            ->integer('assessed_by')
            ->allowEmptyString('assessed_by');

        $validator
            ->dateTime('assessed_at')
            ->allowEmptyDateTime('assessed_at');

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
        $rules->add($rules->existsIn(['risk_id'], 'Risks'), ['errorField' => 'risk_id']);

        return $rules;
    }
}
