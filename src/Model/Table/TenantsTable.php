<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenants Model
 *
 * @property \App\Model\Table\ContactsTable&\Cake\ORM\Association\BelongsTo $Contacts
 * @property \App\Model\Table\EnrolmentsTable&\Cake\ORM\Association\HasMany $Enrolments
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\Tenant newEmptyEntity()
 * @method \App\Model\Entity\Tenant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Tenant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Tenant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Tenant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Tenant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Tenant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tenant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tenant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tenant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tenant> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TenantsTable extends Table
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

        $this->setTable('tenants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
        ]);
        $this->hasMany('Enrolments', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'tenant_id',
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

        return $rules;
    }
}
