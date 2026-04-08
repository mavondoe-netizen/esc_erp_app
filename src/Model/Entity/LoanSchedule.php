<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanSchedule Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property int $period_number
 * @property \Cake\I18n\Date $due_date
 * @property string $principal_due
 * @property string $interest_due
 * @property string $penalty_due
 * @property string $total_due
 * @property string $amount_paid
 * @property string $balance
 * @property string $currency
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Loan $loan
 */
class LoanSchedule extends Entity
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
        'period_number' => true,
        'due_date' => true,
        'principal_due' => true,
        'interest_due' => true,
        'penalty_due' => true,
        'total_due' => true,
        'amount_paid' => true,
        'balance' => true,
        'currency' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
    ];
}
