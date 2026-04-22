<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Setting Entity
 *
 * @property int $id
 * @property string $nssa_ceiling
 * @property string $nssa_rate
 * @property float|null $apwcs_rate
 */
class Setting extends Entity
{
    protected array $_accessible = [
        'nssa_ceiling' => true,
        'nssa_rate'    => true,
        'apwcs_rate'   => true,
        'created'      => true,
        'modified'     => true,
    ];
}
