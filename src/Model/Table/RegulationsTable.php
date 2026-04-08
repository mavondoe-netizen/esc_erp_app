<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Regulations Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ComplianceObligationsTable&\Cake\ORM\Association\HasMany $ComplianceObligations
 *
 * @method \App\Model\Entity\Regulation newEmptyEntity()
 * @method \App\Model\Entity\Regulation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Regulation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Regulation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Regulation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Regulation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Regulation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Regulation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Regulation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Regulation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Regulation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Regulation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Regulation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Regulation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Regulation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Regulation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Regulation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RegulationsTable extends Table
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

        $this->setTable('regulations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('ComplianceObligations', [
            'foreignKey' => 'regulation_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('regulator')
            ->maxLength('regulator', 255)
            ->allowEmptyString('regulator');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
