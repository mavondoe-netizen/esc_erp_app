<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DebitNote Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $supplier_id
 * @property \Cake\I18n\Date $date
 * @property string|null $description
 * @property string|null $total
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\DebitNoteItem[] $debit_note_items
 */
class DebitNote extends Entity
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
        'company_id' => true,
        'supplier_id' => true,
        'date' => true,
        'description' => true,
        'total' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'supplier' => true,
        'debit_note_items' => true,
    ];
}
