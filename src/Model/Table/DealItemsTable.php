<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DealItems Model
 */
class DealItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('deal_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Deals',    ['foreignKey' => 'deal_id']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id']);
        $this->belongsTo('Accounts', ['foreignKey' => 'account_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('deal_id')->notEmptyString('deal_id');
        $validator->decimal('quantity')->notEmptyString('quantity');
        $validator->decimal('unit_price')->notEmptyString('unit_price');
        $validator->decimal('vat_rate')->allowEmptyString('vat_rate');
        $validator->decimal('vat_amount')->allowEmptyString('vat_amount');
        $validator->decimal('line_total')->allowEmptyString('line_total');
        $validator->scalar('description')->allowEmptyString('description');
        $validator->scalar('vat_type')->allowEmptyString('vat_type');
        $validator->scalar('hs_code')->allowEmptyString('hs_code');
        $validator->integer('product_id')->allowEmptyString('product_id');
        $validator->integer('account_id')->allowEmptyString('account_id');

        return $validator;
    }
}
