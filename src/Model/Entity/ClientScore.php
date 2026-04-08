<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientScore Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $score
 * @property string|null $grade
 * @property string|null $risk_level
 * @property string|null $debt_ratio
 * @property string|null $repayment_history_score
 * @property string|null $delinquency_score
 * @property int $active_loans_count
 * @property \Cake\I18n\DateTime|null $computed_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class ClientScore extends Entity
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
        'client_id' => true,
        'score' => true,
        'grade' => true,
        'risk_level' => true,
        'debt_ratio' => true,
        'repayment_history_score' => true,
        'delinquency_score' => true,
        'active_loans_count' => true,
        'computed_at' => true,
        'created' => true,
        'modified' => true,
    ];
}
