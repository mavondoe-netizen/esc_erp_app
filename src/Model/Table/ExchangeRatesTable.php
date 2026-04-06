<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExchangeRates Model
 */
class ExchangeRatesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('exchange_rates');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->decimal('rate_to_base')
            ->requirePresence('rate_to_base', 'create')
            ->notEmptyString('rate_to_base');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        return $validator;
    }
}
