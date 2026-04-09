<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Asset Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $asset_tag
 * @property string $description
 * @property int|null $category_id
 * @property int|null $classification_id
 * @property \Cake\I18n\Date|null $acquisition_date
 * @property string|null $acquisition_cost
 * @property int|null $useful_life
 * @property string $depreciation_method
 * @property string $residual_value
 * @property string|null $current_book_value
 * @property string $status
 * @property int|null $office_id
 * @property int|null $assigned_to
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Office $office
 * @property \App\Model\Entity\AssetAssignment[] $asset_assignments
 * @property \App\Model\Entity\AssetDepreciation[] $asset_depreciation
 * @property \App\Model\Entity\AssetDisposal[] $asset_disposals
 * @property \App\Model\Entity\AssetLog[] $asset_logs
 * @property \App\Model\Entity\AssetRepair[] $asset_repairs
 * @property \App\Model\Entity\AssetTransfer[] $asset_transfers
 */
class Asset extends Entity
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
        'asset_tag' => true,
        'description' => true,
        'category_id' => true,
        'classification_id' => true,
        'acquisition_date' => true,
        'acquisition_cost' => true,
        'useful_life' => true,
        'depreciation_method' => true,
        'residual_value' => true,
        'current_book_value' => true,
        'status' => true,
        'office_id' => true,
        'assigned_to' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'office' => true,
        'asset_assignments' => true,
        'asset_depreciation' => true,
        'asset_disposals' => true,
        'asset_logs' => true,
        'asset_repairs' => true,
        'asset_transfers' => true,
    ];
}
