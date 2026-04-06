<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExchangeRate Entity
 */
class ExchangeRate extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'currency' => true,
        'rate_to_base' => true,
        'date' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];
}
