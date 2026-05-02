<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Evaluations Model
 *
 * @property \App\Model\Table\TendersTable&\Cake\ORM\Association\BelongsTo $Tenders
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Evaluators
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\Evaluation newEmptyEntity()
 * @method \App\Model\Entity\Evaluation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Evaluation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Evaluation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Evaluation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Evaluation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Evaluation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Evaluation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Evaluation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Evaluation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Evaluation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Evaluation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Evaluation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Evaluation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Evaluation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Evaluation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Evaluation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EvaluationsTable extends Table
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

        $this->setTable('evaluations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Tenders', [
            'foreignKey' => 'tender_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'evaluator_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Evaluators', [
            'foreignKey' => 'evaluator_id',
            'className' => 'Users',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
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
            ->integer('tender_id')
            ->notEmptyString('tender_id');

        $validator
            ->integer('evaluator_id')
            ->notEmptyString('evaluator_id');

        $validator
            ->integer('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->decimal('technical_score')
            ->requirePresence('technical_score', 'create')
            ->notEmptyString('technical_score');

        $validator
            ->decimal('financial_score')
            ->requirePresence('financial_score', 'create')
            ->notEmptyString('financial_score');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

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
        $rules->add($rules->existsIn(['tender_id'], 'Tenders'), ['errorField' => 'tender_id']);
        $rules->add($rules->existsIn(['evaluator_id'], 'Evaluators'), ['errorField' => 'evaluator_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
