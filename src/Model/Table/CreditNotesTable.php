<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CreditNotes Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\CreditNoteItemsTable&\Cake\ORM\Association\HasMany $CreditNoteItems
 *
 * @method \App\Model\Entity\CreditNote newEmptyEntity()
 * @method \App\Model\Entity\CreditNote newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CreditNote> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CreditNote get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CreditNote findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CreditNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CreditNote> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CreditNote|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CreditNote saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNote>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNote> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNote>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNote> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CreditNotesTable extends Table
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

        $this->setTable('credit_notes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');
        $this->addBehavior('AuditLog');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CreditNoteItems', [
            'foreignKey' => 'credit_note_id',
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
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->decimal('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
