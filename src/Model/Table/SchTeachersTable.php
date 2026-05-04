<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SchTeachers Model
 */
class SchTeachersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sch_teachers');
        $this->setDisplayField('employee_no');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
            ->scalar('employee_no')
            ->maxLength('employee_no', 50)
            ->requirePresence('employee_no', 'create')
            ->notEmptyString('employee_no')
            ->add('employee_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('specialty')
            ->maxLength('specialty', 255)
            ->allowEmptyString('specialty');

        return $validator;
    }
}
