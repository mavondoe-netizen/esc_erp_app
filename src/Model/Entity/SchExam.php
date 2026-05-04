<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchExam Entity
 */
class SchExam extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'name' => true,
        'term' => true,
        'year' => true,
        'date' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'sch_results' => true,
    ];
}
