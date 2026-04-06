<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BankTransactionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('bank_transactions');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('BankAccounts', [
            'className' => 'Accounts',
            'foreignKey' => 'bank_account_id',
        ]);
        $this->belongsTo('SystemTransactions', [
            'className' => 'Transactions',
            'foreignKey' => 'transaction_id',
        ]);
        $this->hasMany('Splits', [
            'className' => 'Transactions',
            'foreignKey' => 'bank_transaction_id',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        return $validator;
    }
}
