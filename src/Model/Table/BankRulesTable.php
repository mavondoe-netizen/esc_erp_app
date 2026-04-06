<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BankRulesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('bank_rules');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('match_text')
            ->requirePresence('match_text', 'create')
            ->notEmptyString('match_text');

        $validator
            ->integer('account_id')
            ->requirePresence('account_id', 'create')
            ->notEmptyString('account_id');

        return $validator;
    }
}
