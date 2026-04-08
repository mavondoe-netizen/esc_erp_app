<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComplianceObligation Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $regulation_id
 * @property string $requirement
 * @property string|null $frequency
 * @property int|null $owner_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Regulation $regulation
 */
class ComplianceObligation extends Entity
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
        'regulation_id' => true,
        'requirement' => true,
        'frequency' => true,
        'owner_id' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'regulation' => true,
    ];
}
