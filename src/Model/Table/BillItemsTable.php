<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillItems Model
 *
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\BelongsTo $Bills
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\BillItem newEmptyEntity()
 * @method \App\Model\Entity\BillItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BillItemsTable extends Table
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

        $this->setTable('bill_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bills', [
            'foreignKey' => 'bill_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->integer('bill_id')
            ->notEmptyString('bill_id');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->numeric('unit_price')
            ->requirePresence('unit_price', 'create')
            ->notEmptyString('unit_price');

        $validator
            ->numeric('line_total')
            ->requirePresence('line_total', 'create')
            ->notEmptyString('line_total');

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
        $rules->add($rules->existsIn(['bill_id'], 'Bills'), ['errorField' => 'bill_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);

        return $rules;
    }
}
