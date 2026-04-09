<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetTransfer Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property int|null $from_office_id
 * @property int|null $to_office_id
 * @property \Cake\I18n\Date $transfer_date
 * @property int|null $approved_by
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 */
class AssetTransfer extends Entity
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
        'from_office_id' => true,
        'to_office_id' => true,
        'transfer_date' => true,
        'approved_by' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'asset' => true,
    ];
}
