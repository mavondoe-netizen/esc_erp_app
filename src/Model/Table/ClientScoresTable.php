<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientScores Model
 *
 * @method \App\Model\Entity\ClientScore newEmptyEntity()
 * @method \App\Model\Entity\ClientScore newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ClientScore> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientScore get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ClientScore findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ClientScore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ClientScore> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientScore|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ClientScore saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ClientScore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ClientScore>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ClientScore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ClientScore> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ClientScore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ClientScore>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ClientScore>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ClientScore> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientScoresTable extends Table
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

        $this->setTable('client_scores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('client_id')
            ->requirePresence('client_id', 'create')
            ->notEmptyString('client_id');

        $validator
            ->integer('score')
            ->notEmptyString('score');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 5)
            ->allowEmptyString('grade');

        $validator
            ->scalar('risk_level')
            ->maxLength('risk_level', 20)
            ->allowEmptyString('risk_level');

        $validator
            ->decimal('debt_ratio')
            ->allowEmptyString('debt_ratio');

        $validator
            ->decimal('repayment_history_score')
            ->allowEmptyString('repayment_history_score');

        $validator
            ->decimal('delinquency_score')
            ->allowEmptyString('delinquency_score');

        $validator
            ->integer('active_loans_count')
            ->notEmptyString('active_loans_count');

        $validator
            ->dateTime('computed_at')
            ->allowEmptyDateTime('computed_at');

        return $validator;
    }
}
