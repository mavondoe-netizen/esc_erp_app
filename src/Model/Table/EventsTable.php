<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @method \App\Model\Entity\Event newEmptyEntity()
 * @method \App\Model\Entity\Event newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Event> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Event findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Event> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Event saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Event>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Event>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Event>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Event> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Event>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Event>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Event>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Event> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventsTable extends Table
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

        $this->setTable('events');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        return $validator;
    }
}
