<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Departments Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 */
class DepartmentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('departments');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'department_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'department_id',
        ]);
        $this->hasMany('Invoices', [
            'foreignKey' => 'department_id',
        ]);
        $this->hasMany('Bills', [
            'foreignKey' => 'department_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
