<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssetCategory Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property int|null $default_useful_life
 * @property string $depreciation_method
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 */
class AssetCategory extends Entity
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
        'name' => true,
        'default_useful_life' => true,
        'depreciation_method' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];
}
