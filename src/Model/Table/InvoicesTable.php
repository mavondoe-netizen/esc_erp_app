<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
//use Cake\ORM\Table;
use Cake\Event\EventInterface;
use ArrayObject;
/**
 * Invoices Model
 *
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\InvoiceItemsTable&\Cake\ORM\Association\HasMany $InvoiceItems
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsToMany $Accounts
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\BelongsToMany $Transactions
 *
 * @method \App\Model\Entity\Invoice newEmptyEntity()
 * @method \App\Model\Entity\Invoice newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Invoice> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Invoice findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Invoice> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Invoice saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InvoicesTable extends Table
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

        $this->setTable('invoices');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('InvoiceItems', [
            'foreignKey' => 'invoice_id',
        ]);
        $this->belongsToMany('Accounts', [
            'foreignKey' => 'invoice_id',
            'targetForeignKey' => 'account_id',
            'joinTable' => 'accounts_invoices',
        ]);
        $this->belongsToMany('Transactions', [
            'foreignKey' => 'invoice_id',
            'targetForeignKey' => 'transaction_id',
            'joinTable' => 'invoices_transactions',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 151)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->scalar('description')
            ->maxLength('description', 151)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('status')
            ->maxLength('status', 151)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
    // src/Model/Table/InvoicesTable.php

    
}


