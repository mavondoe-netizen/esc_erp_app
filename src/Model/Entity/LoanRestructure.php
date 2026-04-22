<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanRestructure Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property int|null $old_term
 * @property int $new_term
 * @property string|null $old_rate
 * @property string|null $new_rate
 * @property string|null $outstanding_at_restructure
 * @property string|null $reason
 * @property string $status
 * @property int|null $approved_by
 * @property \Cake\I18n\DateTime|null $approved_at
 * @property \Cake\I18n\Date|null $effective_date
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Loan $loan
 */
class LoanRestructure extends Entity
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
        'old_term' => true,
        'new_term' => true,
        'old_rate' => true,
        'new_rate' => true,
        'outstanding_at_restructure' => true,
        'reason' => true,
        'status' => true,
        'approved_by' => true,
        'approved_at' => true,
        'effective_date' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
    ];
}
