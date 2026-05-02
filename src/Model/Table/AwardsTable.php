<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Awards Model
 *
 * @property \App\Model\Table\TendersTable&\Cake\ORM\Association\BelongsTo $Tenders
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\HasMany $Bills
 * @property \App\Model\Table\ContractsTable&\Cake\ORM\Association\HasMany $Contracts
 *
 * @method \App\Model\Entity\Award newEmptyEntity()
 * @method \App\Model\Entity\Award newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Award> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Award get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Award findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Award patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Award> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Award|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Award saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Award>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Award>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Award>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Award> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Award>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Award>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Award>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Award> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AwardsTable extends Table
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

        $this->setTable('awards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Tenders', [
            'foreignKey' => 'tender_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Bills', [
            'foreignKey' => 'award_id',
        ]);
        $this->hasMany('Contracts', [
            'foreignKey' => 'award_id',
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
            ->integer('tender_id')
            ->notEmptyString('tender_id');

        $validator
            ->integer('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->decimal('awarded_amount')
            ->requirePresence('awarded_amount', 'create')
            ->notEmptyString('awarded_amount');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['tender_id'], 'Tenders'), ['errorField' => 'tender_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
