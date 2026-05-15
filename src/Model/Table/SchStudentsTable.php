<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchStudents Model
 */
class SchStudentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sch_students');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
        ]);
        $this->belongsTo('SchClasses', [
            'foreignKey' => 'class_id',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('SchResults', [
            'foreignKey' => 'student_id',
        ]);
        $this->hasMany('SchAttendance', [
            'foreignKey' => 'student_id',
        ]);
        $this->hasMany('Invoices', [
            'foreignKey' => 'student_id',
        ]);
        $this->hasMany('Receipts', [
            'foreignKey' => 'student_id',
        ]);
        // Legacy: kept for data reference
        $this->hasMany('SchFees', [
            'foreignKey' => 'student_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->scalar('admission_no')
            ->maxLength('admission_no', 50)
            ->requirePresence('admission_no', 'create')
            ->notEmptyString('admission_no')
            ->add('admission_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('date_of_birth')
            ->allowEmptyDate('date_of_birth');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 10)
            ->allowEmptyString('gender');

        $validator
            ->scalar('guardian_name')
            ->maxLength('guardian_name', 100)
            ->allowEmptyString('guardian_name');

        $validator
            ->scalar('guardian_phone')
            ->maxLength('guardian_phone', 20)
            ->allowEmptyString('guardian_phone');

        return $validator;
    }
}
