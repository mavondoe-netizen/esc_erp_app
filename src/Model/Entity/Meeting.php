<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meeting Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $contact_id
 * @property int $user_id
 * @property string $agenda
 * @property string $outcomes
 * @property string $attachments
 *
 * @property \App\Model\Entity\Contact $contact
 * @property \App\Model\Entity\User $user
 */
class Meeting extends Entity
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
        'contact_id' => true,
        'user_id' => true,
        'agenda' => true,
        'outcomes' => true,
        'attachments' => true,
        'contact' => true,
        'user' => true,
    ];
}
