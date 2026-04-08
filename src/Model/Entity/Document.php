<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $entity_type
 * @property int $entity_id
 * @property string $file_path
 * @property string|null $file_name
 * @property int|null $uploaded_by
 * @property \Cake\I18n\DateTime|null $uploaded_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 */
class Document extends Entity
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
        'entity_type' => true,
        'entity_id' => true,
        'file_path' => true,
        'file_name' => true,
        'uploaded_by' => true,
        'uploaded_at' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];
}
