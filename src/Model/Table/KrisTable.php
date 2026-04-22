<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Kris Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\RisksTable&\Cake\ORM\Association\BelongsTo $Risks
 *
 * @method \App\Model\Entity\Kri newEmptyEntity()
 * @method \App\Model\Entity\Kri newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Kri> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Kri get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Kri findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Kri patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Kri> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Kri|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Kri saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Kri>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Kri>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Kri>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Kri> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Kri>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Kri>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Kri>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Kri> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KrisTable extends Table
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

        $this->setTable('kris');
        $this->setDisplayField('metric');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

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
            ->scalar('metric')
            ->maxLength('metric', 255)
            ->requirePresence('metric', 'create')
            ->notEmptyString('metric');

        $validator
            ->decimal('threshold')
            ->requirePresence('threshold', 'create')
            ->notEmptyString('threshold');

        $validator
            ->decimal('current_value')
            ->requirePresence('current_value', 'create')
            ->notEmptyString('current_value');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

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
