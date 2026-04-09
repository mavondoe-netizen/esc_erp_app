<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetLog Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $asset_id
 * @property string $action
 * @property int|null $user_id
 * @property \Cake\I18n\DateTime $timestamp
 * @property string|null $details
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Asset $asset
 * @property \App\Model\Entity\User $user
 */
class AssetLog extends Entity
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
        'action' => true,
        'user_id' => true,
        'timestamp' => true,
        'details' => true,
        'company' => true,
        'asset' => true,
        'user' => true,
    ];
}
