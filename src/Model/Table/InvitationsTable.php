<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invitations Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\Invitation newEmptyEntity()
 * @method \App\Model\Entity\Invitation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Invitation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invitation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Invitation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Invitation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Invitation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invitation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Invitation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Invitation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invitation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invitation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invitation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invitation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invitation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invitation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invitation> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvitationsTable extends Table
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

        $this->setTable('invitations');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
