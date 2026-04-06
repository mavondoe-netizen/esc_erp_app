<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class BankRule extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'match_text' => true,
        'account_id' => true,
        'created' => true,
        'modified' => true,
    ];
}
