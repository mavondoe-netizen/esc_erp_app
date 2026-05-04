<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchResults Model
 */
class SchResultsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sch_results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('SchStudents', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SchSubjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SchExams', [
            'foreignKey' => 'exam_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->decimal('marks')
            ->allowEmptyString('marks');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 10)
            ->allowEmptyString('grade');

        $validator
            ->scalar('remarks')
            ->allowEmptyString('remarks');

        return $validator;
    }
}
