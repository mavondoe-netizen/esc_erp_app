<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invitation Entity
 *
 * @property int $id
 * @property string $email
 * @property int $company_id
 * @property int $role_id
 * @property string $token
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Role $role
 */
class Invitation extends Entity
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
        'email' => true,
        'company_id' => true,
        'role_id' => true,
        'token' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'role' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'token',
    ];
}
