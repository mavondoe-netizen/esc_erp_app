<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchAttendance Entity
 */
class SchAttendance extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'student_id' => true,
        'date' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'sch_student' => true,
        'company' => true,
    ];
}
