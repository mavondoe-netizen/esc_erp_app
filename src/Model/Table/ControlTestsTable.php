<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControlTests Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ControlsTable&\Cake\ORM\Association\BelongsTo $Controls
 *
 * @method \App\Model\Entity\ControlTest newEmptyEntity()
 * @method \App\Model\Entity\ControlTest newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ControlTest> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControlTest get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ControlTest findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ControlTest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ControlTest> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControlTest|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ControlTest saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ControlTest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ControlTest>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ControlTest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ControlTest> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ControlTest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ControlTest>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ControlTest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ControlTest> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ControlTestsTable extends Table
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

        $this->setTable('control_tests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Controls', [
            'foreignKey' => 'control_id',
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
            ->integer('control_id')
            ->notEmptyString('control_id');

        $validator
            ->scalar('test_result')
            ->allowEmptyString('test_result');

        $validator
            ->integer('tested_by')
            ->allowEmptyString('tested_by');

        $validator
            ->dateTime('tested_at')
            ->allowEmptyDateTime('tested_at');

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
        $rules->add($rules->existsIn(['control_id'], 'Controls'), ['errorField' => 'control_id']);

        return $rules;
    }
}
