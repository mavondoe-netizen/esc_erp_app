<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DealItem Entity
 */
class DealItem extends Entity
{
    protected array $_accessible = [
        'deal_id'     => true,
        'product_id'  => true,
        'account_id'  => true,
        'description' => true,
        'quantity'    => true,
        'unit_price'  => true,
        'vat_rate'    => true,
        'vat_amount'  => true,
        'vat_type'    => true,
        'hs_code'     => true,
        'line_total'  => true,
        'product'     => true,
        'account'     => true,
        'deal'        => true,
    ];
}
