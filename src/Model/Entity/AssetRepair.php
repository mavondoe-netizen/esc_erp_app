<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetRepair Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property string $issue_description
 * @property string $repair_type
 * @property string|null $vendor
 * @property string $cost
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $end_date
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 */
class AssetRepair extends Entity
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
        'issue_description' => true,
        'repair_type' => true,
        'vendor' => true,
        'cost' => true,
        'start_date' => true,
        'end_date' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'asset' => true,
    ];
}
