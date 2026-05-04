<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchResult Entity
 */
class SchResult extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'student_id' => true,
        'subject_id' => true,
        'exam_id' => true,
        'marks' => true,
        'grade' => true,
        'remarks' => true,
        'created' => true,
        'modified' => true,
        'sch_student' => true,
        'sch_subject' => true,
        'sch_exam' => true,
        'company' => true,
    ];
}
