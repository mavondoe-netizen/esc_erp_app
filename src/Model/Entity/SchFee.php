<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchFee Entity
 */
class SchFee extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'student_id' => true,
        'amount' => true,
        'paid' => true,
        'due_date' => true,
        'created' => true,
        'modified' => true,
        'sch_student' => true,
        'company' => true,
    ];
}
