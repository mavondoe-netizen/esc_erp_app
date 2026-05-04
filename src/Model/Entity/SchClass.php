<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchClass Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string|null $academic_period
 * @property string|null $section
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\SchSubject[] $sch_subjects
 * @property \App\Model\Entity\SchStudent[] $sch_students
 */
class SchClass extends Entity
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
        'name' => true,
        'academic_period' => true,
        'section' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'sch_subjects' => true,
        'sch_students' => true,
    ];
}
