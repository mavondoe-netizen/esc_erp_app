<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transactions Model
 *
 * @property \App\Model\Table\BankTransactionsTable&\Cake\ORM\Association\BelongsTo $BankTransactions
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\DepartmentsTable&\Cake\ORM\Association\BelongsTo $Departments
 * @property \App\Model\Table\BuildingsTable&\Cake\ORM\Association\BelongsTo $Buildings
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\PayPeriodsTable&\Cake\ORM\Association\BelongsTo $Payperiods
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\BelongsTo $Bills
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\BankTransactionsTable&\Cake\ORM\Association\HasMany $BankTransactions
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\BelongsToMany $Bills
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsToMany $Invoices
 * @property \App\Model\Table\ReceiptsTable&\Cake\ORM\Association\BelongsToMany $Receipts
 *
 * @method \App\Model\Entity\Transaction newEmptyEntity()
 * @method \App\Model\Entity\Transaction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Transaction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Transaction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Transaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Transaction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Transaction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Transaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TransactionsTable extends Table
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

        $this->setTable('transactions');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

       
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
        ]);
        $this->belongsTo('Buildings', [
            'foreignKey' => 'building_id',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->belongsTo('Payperiods', [
            'foreignKey' => 'payperiod_id',
        ]);
       
        
        $this->hasMany('BankTransactions', [
            'foreignKey' => 'transaction_id',
        ]);
        $this->belongsToMany('Bills', [
            'foreignKey' => 'transaction_id',
            'targetForeignKey' => 'bill_id',
            'joinTable' => 'bills_transactions',
        ]);
        $this->belongsToMany('Invoices', [
            'foreignKey' => 'transaction_id',
            'targetForeignKey' => 'invoice_id',
            'joinTable' => 'invoices_transactions',
        ]);
        $this->belongsToMany('Receipts', [
            'foreignKey' => 'transaction_id',
            'targetForeignKey' => 'receipt_id',
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
            ->integer('bank_transaction_id')
            ->allowEmptyString('bank_transaction_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('description')
            ->maxLength('description', 151)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
            ->numeric('zwg')
            ->requirePresence('zwg', 'create')
            ->notEmptyString('zwg');

        $validator
            ->scalar('type')
            ->maxLength('type', 11)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->integer('department_id')
            ->allowEmptyString('department_id');

        $validator
            ->integer('building_id')
            ->allowEmptyString('building_id');

        $validator
            ->integer('tenant_id')
            ->allowEmptyString('tenant_id');

        $validator
            ->integer('supplier_id')
            ->allowEmptyString('supplier_id');

        $validator
            ->integer('customer_id')
            ->allowEmptyString('customer_id');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->integer('payperiod_id')
            ->allowEmptyString('payperiod_id');

        $validator
            ->integer('bill_id')
            ->allowEmptyString('bill_id');

        $validator
            ->integer('invoice_id')
            ->allowEmptyString('invoice_id');

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
        $rules->add($rules->existsIn(['bank_transaction_id'], 'BankTransactions'), ['errorField' => 'bank_transaction_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['department_id'], 'Departments'), ['errorField' => 'department_id']);
        $rules->add($rules->existsIn(['building_id'], 'Buildings'), ['errorField' => 'building_id']);
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'), ['errorField' => 'tenant_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['payperiod_id'], 'Payperiods'), ['errorField' => 'payperiod_id']);
        $rules->add($rules->existsIn(['bill_id'], 'Bills'), ['errorField' => 'bill_id']);
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'), ['errorField' => 'invoice_id']);

        return $rules;
    }
}
