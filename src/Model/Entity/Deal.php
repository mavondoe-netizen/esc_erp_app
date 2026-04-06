<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Deal Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Cake\I18n\Date $date
 * @property string $type
 * @property string $value
 * @property string $stage
 * @property int|null $contact_id
 * @property string $status
 * @property int|null $submitted_by
 * @property \Cake\I18n\DateTime|null $submitted_at
 * @property int|null $approved_by
 * @property \Cake\I18n\DateTime|null $approved_at
 * @property int|null $rejected_by
 * @property \Cake\I18n\DateTime|null $rejected_at
 * @property string|null $rejection_reason
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Contact $contact
 */
class Deal extends Entity
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
        'name' => true,
        'description' => true,
        'date' => true,
        'type' => true,
        'value' => true,
        'stage' => true,
        'contact_id' => true,
        'status' => true,
        'submitted_by' => true,
        'submitted_at' => true,
        'approved_by' => true,
        'approved_at' => true,
        'rejected_by' => true,
        'rejected_at' => true,
        'rejection_reason' => true,
        'company_id' => true,
        'contact' => true,
    ];
}
