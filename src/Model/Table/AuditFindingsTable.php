<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuditFindings Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\BelongsTo $Audits
 *
 * @method \App\Model\Entity\AuditFinding newEmptyEntity()
 * @method \App\Model\Entity\AuditFinding newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditFinding> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditFinding get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AuditFinding findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AuditFinding patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditFinding> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditFinding|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AuditFinding saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AuditFinding>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditFinding>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditFinding>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditFinding> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditFinding>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditFinding>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditFinding>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditFinding> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditFindingsTable extends Table
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

        $this->setTable('audit_findings');
        $this->setDisplayField('risk_level');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Audits', [
            'foreignKey' => 'audit_id',
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
            ->integer('audit_id')
            ->notEmptyString('audit_id');

        $validator
            ->scalar('finding')
            ->requirePresence('finding', 'create')
            ->notEmptyString('finding');

        $validator
            ->scalar('risk_level')
            ->maxLength('risk_level', 50)
            ->requirePresence('risk_level', 'create')
            ->notEmptyString('risk_level');

        $validator
            ->scalar('root_cause')
            ->allowEmptyString('root_cause');

        $validator
            ->scalar('recommendation')
            ->allowEmptyString('recommendation');

        $validator
            ->scalar('management_response')
            ->allowEmptyString('management_response');

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
        $rules->add($rules->existsIn(['audit_id'], 'Audits'), ['errorField' => 'audit_id']);

        return $rules;
    }
}
