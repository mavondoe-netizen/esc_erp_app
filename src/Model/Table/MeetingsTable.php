<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Meetings Model
 *
 * @property \App\Model\Table\ContactsTable&\Cake\ORM\Association\BelongsTo $Contacts
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Meeting newEmptyEntity()
 * @method \App\Model\Entity\Meeting newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Meeting> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Meeting get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Meeting findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Meeting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Meeting> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Meeting|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Meeting saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Meeting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Meeting>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Meeting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Meeting> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Meeting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Meeting>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Meeting>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Meeting> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MeetingsTable extends Table
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

        $this->setTable('meetings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('name')
            ->maxLength('name', 151)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('contact_id')
            ->allowEmptyString('contact_id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('agenda')
            ->maxLength('agenda', 151)
            ->requirePresence('agenda', 'create')
            ->notEmptyString('agenda');

        $validator
            ->scalar('outcomes')
            ->maxLength('outcomes', 151)
            ->requirePresence('outcomes', 'create')
            ->notEmptyString('outcomes');

        $validator
            ->scalar('attachments')
            ->maxLength('attachments', 151)
            ->requirePresence('attachments', 'create')
            ->notEmptyString('attachments');

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
        $rules->add($rules->existsIn(['contact_id'], 'Contacts'), ['errorField' => 'contact_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
