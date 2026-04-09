<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetDepreciation Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property string $period
 * @property string $depreciation_amount
 * @property string $accumulated_depreciation
 * @property string $book_value
 * @property bool $posted_to_ledger
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 */
class AssetDepreciation extends Entity
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
        'period' => true,
        'depreciation_amount' => true,
        'accumulated_depreciation' => true,
        'book_value' => true,
        'posted_to_ledger' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'asset' => true,
    ];
}
