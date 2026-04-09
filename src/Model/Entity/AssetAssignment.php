<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetAssignment Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property int|null $office_id
 * @property int|null $department_id
 * @property int|null $assigned_to
 * @property \Cake\I18n\Date $assigned_date
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 * @property \App\Model\Entity\Office $office
 * @property \App\Model\Entity\Department $department
 */
class AssetAssignment extends Entity
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
        'asset_id' => true,
        'office_id' => true,
        'department_id' => true,
        'assigned_to' => true,
        'assigned_date' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'asset' => true,
        'office' => true,
        'department' => true,
    ];
}
