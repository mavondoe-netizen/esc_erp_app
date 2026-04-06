<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 * @method \App\Model\Entity\Module newEmptyEntity()
 * @method \App\Model\Entity\Module newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Module> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Module get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Module findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Module patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Module> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Module|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Module saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Module>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Module> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Module>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Module> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModulesTable extends Table
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

        $this->setTable('modules');
        $this->setDisplayField('name');
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->scalar('model')
            ->maxLength('model', 100)
            ->allowEmptyString('model');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
