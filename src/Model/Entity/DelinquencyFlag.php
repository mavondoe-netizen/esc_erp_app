<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DelinquencyFlag Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property int $days_overdue
 * @property string $amount_overdue
 * @property string $currency
 * @property string $category
 * @property \Cake\I18n\DateTime|null $flagged_at
 * @property \Cake\I18n\DateTime|null $resolved_at
 * @property bool $notification_sent
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Loan $loan
 */
class DelinquencyFlag extends Entity
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
        'loan_id' => true,
        'days_overdue' => true,
        'amount_overdue' => true,
        'currency' => true,
        'category' => true,
        'flagged_at' => true,
        'resolved_at' => true,
        'notification_sent' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
    ];
}
