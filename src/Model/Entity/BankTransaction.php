<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class BankTransaction extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'bank_account_id' => true,
        'date' => true,
        'description' => true,
        'amount' => true,
        'reference' => true,
        'reconciled' => true,
        'transaction_id' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Ensure amount is always returned as a float.
     */
    protected function _getAmount($value): float
    {
        return (float)$value;
    }
}
