<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Budget Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $company_id
 * @property string $amount
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Company $company
 */
class Budget extends Entity
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
        'account_id' => true,
        'company_id' => true,
        'amount' => true,
        'start_date' => true,
        'end_date' => true,
        'created' => true,
        'modified' => true,
        'account' => true,
        'company' => true,
    ];
}
