<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Audits Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AuditPlansTable&\Cake\ORM\Association\BelongsTo $AuditPlans
 * @property \App\Model\Table\AuditFindingsTable&\Cake\ORM\Association\HasMany $AuditFindings
 *
 * @method \App\Model\Entity\Audit newEmptyEntity()
 * @method \App\Model\Entity\Audit newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Audit> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Audit get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Audit findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Audit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Audit> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Audit|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Audit saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Audit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Audit>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Audit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Audit> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Audit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Audit>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Audit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Audit> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditsTable extends Table
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

        $this->setTable('audits');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('AuditPlans', [
            'foreignKey' => 'audit_plan_id',
        ]);
        $this->hasMany('AuditFindings', [
            'foreignKey' => 'audit_id',
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
            ->integer('audit_plan_id')
            ->allowEmptyString('audit_plan_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('scope')
            ->allowEmptyString('scope');

        $validator
            ->integer('auditor_id')
            ->allowEmptyString('auditor_id');

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
        $rules->add($rules->existsIn(['audit_plan_id'], 'AuditPlans'), ['errorField' => 'audit_plan_id']);

        return $rules;
    }
}
