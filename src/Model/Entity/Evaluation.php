<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Evaluation Entity
 *
 * @property int $id
 * @property int $tender_id
 * @property int $evaluator_id
 * @property int $supplier_id
 * @property string $technical_score
 * @property string $financial_score
 * @property string|null $comments
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Tender $tender
 * @property \App\Model\Entity\User $evaluator
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Company $company
 */
class Evaluation extends Entity
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
        'tender_id' => true,
        'evaluator_id' => true,
        'supplier_id' => true,
        'technical_score' => true,
        'financial_score' => true,
        'comments' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'tender' => true,
        'evaluator' => true,
        'supplier' => true,
        'company' => true,
    ];
}
