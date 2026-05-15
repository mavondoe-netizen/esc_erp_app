<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchStudent Entity
 */
class SchStudent extends Entity
{
    protected array $_accessible = [
        'company_id'      => true,
        'user_id'         => true,
        'guardian_user_id'=> true,
        'admission_no'    => true,
        'first_name'      => true,
        'last_name'       => true,
        'gender'          => true,
        'class_id'        => true,
        'date_of_birth'   => true,
        'guardian_name'   => true,
        'guardian_phone'  => true,
        'contact_id'      => true,
        'created'         => true,
        'modified'        => true,
        'user'            => true,
        'guardian'        => true,
        'sch_class'       => true,
        'company'         => true,
        'sch_results'     => true,
        'sch_attendance'  => true,
        'sch_fees'        => true,
    ];
}
