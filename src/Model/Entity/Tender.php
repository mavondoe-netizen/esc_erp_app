<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tender Entity
 *
 * @property int $id
 * @property int $procurement_id
 * @property string $title
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $closing_date
 * @property string|null $status
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Procurement $procurement
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Award[] $awards
 * @property \App\Model\Entity\Evaluation[] $evaluations
 * @property \App\Model\Entity\TenderBid[] $tender_bids
 */
class Tender extends Entity
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
        'procurement_id' => true,
        'title' => true,
        'description' => true,
        'closing_date' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'procurement' => true,
        'company' => true,
        'awards' => true,
        'evaluations' => true,
        'tender_bids' => true,
    ];
}
