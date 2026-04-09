<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Offices Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AssetAssignmentsTable&\Cake\ORM\Association\HasMany $AssetAssignments
 * @property \App\Model\Table\AssetsTable&\Cake\ORM\Association\HasMany $Assets
 *
 * @method \App\Model\Entity\Office newEmptyEntity()
 * @method \App\Model\Entity\Office newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Office> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Office get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Office findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Office patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Office> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Office|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Office saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Office>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Office>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Office>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Office> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Office>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Office>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Office>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Office> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OfficesTable extends Table
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
        $this->addBehavior('TenantAware');

        $this->setTable('offices');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('AssetAssignments', [
            'foreignKey' => 'office_id',
        ]);
        $this->hasMany('Assets', [
            'foreignKey' => 'office_id',
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
            ->notEmptyString('company_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

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
