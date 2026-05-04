<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchSubject Entity
 */
class SchSubject extends Entity
{
    protected array $_accessible = [
        'company_id' => true,
        'name' => true,
        'class_id' => true,
        'created' => true,
        'modified' => true,
        'sch_class' => true,
        'company' => true,
    ];
}
