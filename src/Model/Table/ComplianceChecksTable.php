<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComplianceChecks Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\ComplianceCheck newEmptyEntity()
 * @method \App\Model\Entity\ComplianceCheck newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ComplianceCheck> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComplianceCheck get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ComplianceCheck findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ComplianceCheck patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ComplianceCheck> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComplianceCheck|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ComplianceCheck saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceCheck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceCheck>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceCheck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceCheck> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceCheck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceCheck>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ComplianceCheck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ComplianceCheck> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ComplianceChecksTable extends Table
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

        $this->setTable('compliance_checks');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->integer('obligation_id')
            ->requirePresence('obligation_id', 'create')
            ->notEmptyString('obligation_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('evidence')
            ->allowEmptyString('evidence');

        $validator
            ->dateTime('checked_at')
            ->allowEmptyDateTime('checked_at');

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
