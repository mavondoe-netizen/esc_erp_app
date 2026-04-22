<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Risks Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ControlsTable&\Cake\ORM\Association\HasMany $Controls
 * @property \App\Model\Table\KrisTable&\Cake\ORM\Association\HasMany $Kris
 * @property \App\Model\Table\RiskAssessmentsTable&\Cake\ORM\Association\HasMany $RiskAssessments
 *
 * @method \App\Model\Entity\Risk newEmptyEntity()
 * @method \App\Model\Entity\Risk newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Risk> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Risk get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Risk findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Risk patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Risk> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Risk|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Risk saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Risk>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Risk>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Risk>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Risk> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Risk>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Risk>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Risk>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Risk> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RisksTable extends Table
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

        $this->setTable('risks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Controls', [
            'foreignKey' => 'risk_id',
        ]);
        $this->hasMany('Kris', [
            'foreignKey' => 'risk_id',
        ]);
        $this->hasMany('RiskAssessments', [
            'foreignKey' => 'risk_id',
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        $validator
            ->integer('business_unit_id')
            ->allowEmptyString('business_unit_id');

        $validator
            ->integer('owner_id')
            ->allowEmptyString('owner_id');

        $validator
            ->decimal('inherent_risk_score')
            ->allowEmptyString('inherent_risk_score');

        $validator
            ->decimal('residual_risk_score')
            ->allowEmptyString('residual_risk_score');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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

        return $rules;
    }
}
