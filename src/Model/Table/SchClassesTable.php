<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchClasses Model
 *
 * @method \App\Model\Entity\SchClass newEmptyEntity()
 * @method \App\Model\Entity\SchClass newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SchClass> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SchClass get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SchClass findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SchClass patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SchClass> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SchClass|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SchClass saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SchClass>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SchClass>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SchClass>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SchClass> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SchClass>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SchClass>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SchClass>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SchClass> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SchClassesTable extends Table
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

        $this->setTable('sch_classes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('SchSubjects', [
            'foreignKey' => 'class_id',
        ]);
        $this->hasMany('SchStudents', [
            'foreignKey' => 'class_id',
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('academic_period')
            ->maxLength('academic_period', 100)
            ->allowEmptyString('academic_period');

        $validator
            ->scalar('section')
            ->maxLength('section', 50)
            ->allowEmptyString('section');

        return $validator;
    }
}
