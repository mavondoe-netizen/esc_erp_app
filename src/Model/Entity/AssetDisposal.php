<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetDisposal Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property string $disposal_type
 * @property \Cake\I18n\Date $disposal_date
 * @property string $disposal_amount
 * @property string|null $gain_or_loss
 * @property int|null $approved_by
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 */
class AssetDisposal extends Entity
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
        'disposal_type' => true,
        'disposal_date' => true,
        'disposal_amount' => true,
        'gain_or_loss' => true,
        'approved_by' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'asset' => true,
    ];
}
