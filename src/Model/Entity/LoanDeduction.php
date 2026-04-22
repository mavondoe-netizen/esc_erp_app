<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanDeduction Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property int $employee_id
 * @property string $monthly_amount
 * @property string $currency
 * @property string $status
 * @property \Cake\I18n\Date|null $start_date
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Loan $loan
 * @property \App\Model\Entity\Employee $employee
 */
class LoanDeduction extends Entity
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
        'employee_id' => true,
        'monthly_amount' => true,
        'currency' => true,
        'status' => true,
        'start_date' => true,
        'notes' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
        'employee' => true,
    ];
}
