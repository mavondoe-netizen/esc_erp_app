<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DealRequest Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $company_name
 * @property string $message
 * @property string $source
 * @property string $status
 * @property int $company_id
 * @property int $deal_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Deal $deal
 */
class DealRequest extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'phone' => true,
        'company_name' => true,
        'message' => true,
        'source' => true,
        'status' => true,
        'company_id' => true,
        'deal_id' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'deal' => true,
    ];
}
