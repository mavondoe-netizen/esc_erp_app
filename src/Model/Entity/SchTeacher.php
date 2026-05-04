<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchTeacher Entity
 */
class SchTeacher extends Entity
{
    protected array $_accessible = [
        'company_id'  => true,
        'user_id'     => true,
        'employee_id' => true,
        'employee_no' => true,
        'specialty'   => true,
        'created'     => true,
        'modified'    => true,
        'user'        => true,
        'employee'    => true,
        'company'     => true,
    ];
}
