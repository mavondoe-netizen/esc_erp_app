<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Receipts Model
 *
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\BelongsToMany $Transactions
 *
 * @method \App\Model\Entity\Receipt newEmptyEntity()
 * @method \App\Model\Entity\Receipt newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Receipt> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Receipt get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Receipt findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Receipt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Receipt> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Receipt|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Receipt saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Receipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Receipt>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Receipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Receipt> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Receipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Receipt>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Receipt>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Receipt> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ReceiptsTable extends Table
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

        $this->setTable('receipts');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsToMany('Transactions', [
            'foreignKey' => 'receipt_id',
            'targetForeignKey' => 'transaction_id',
            'joinTable' => 'receipts_transactions',
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
            ->integer('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 151)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->integer('account_id')
            ->allowEmptyString('account_id');

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
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);

        return $rules;
    }
}
