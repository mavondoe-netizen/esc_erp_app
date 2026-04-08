<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControlTest Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $control_id
 * @property string|null $test_result
 * @property int|null $tested_by
 * @property \Cake\I18n\DateTime|null $tested_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Control $control
 */
class ControlTest extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'company_id' => true,
        'control_id' => true,
        'test_result' => true,
        'tested_by' => true,
        'tested_at' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'control' => true,
    ];
}
