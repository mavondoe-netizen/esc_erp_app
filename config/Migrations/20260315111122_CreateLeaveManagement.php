<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLeaveManagement extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        // 1. Leave Types
        $leaveTypesTable = $this->table('leave_types');
        $leaveTypesTable->addColumn('name', 'string', ['limit' => 50, 'null' => false])
                        ->addColumn('description', 'text', ['null' => true])
                        ->addColumn('default_days_per_year', 'integer', ['default' => 0, 'null' => false])
                        ->addColumn('is_active', 'boolean', ['default' => true, 'null' => false])
                        ->addColumn('created', 'datetime')
                        ->addColumn('modified', 'datetime')
                        ->create();

        // 2. Leave Balances
        $leaveBalancesTable = $this->table('leave_balances');
        $leaveBalancesTable->addColumn('employee_id', 'integer', ['null' => false])
                           ->addColumn('leave_type_id', 'integer', ['null' => false])
                           ->addColumn('year', 'integer', ['null' => false])
                           ->addColumn('days_entitled', 'decimal', ['default' => 0.0, 'precision' => 5, 'scale' => 2, 'null' => false])
                           ->addColumn('days_taken', 'decimal', ['default' => 0.0, 'precision' => 5, 'scale' => 2, 'null' => false])
                           ->addColumn('created', 'datetime')
                           ->addColumn('modified', 'datetime')
                           ->addIndex(['employee_id', 'leave_type_id', 'year'], ['unique' => true])
                           ->addForeignKey('employee_id', 'employees', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                           ->addForeignKey('leave_type_id', 'leave_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                           ->create();

        // 3. Leave Applications
        $leaveAppsTable = $this->table('leave_applications');
        $leaveAppsTable->addColumn('employee_id', 'integer', ['null' => false])
                       ->addColumn('leave_type_id', 'integer', ['null' => false])
                       ->addColumn('start_date', 'date', ['null' => false])
                       ->addColumn('end_date', 'date', ['null' => false])
                       ->addColumn('days_requested', 'decimal', ['precision' => 5, 'scale' => 2, 'null' => false])
                       ->addColumn('notes', 'text', ['null' => true])
                       ->addColumn('status', 'string', ['limit' => 20, 'default' => 'Pending', 'null' => false]) // Pending, Approved, Rejected
                       ->addColumn('created', 'datetime')
                       ->addColumn('modified', 'datetime')
                       ->addForeignKey('employee_id', 'employees', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                       ->addForeignKey('leave_type_id', 'leave_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                       ->create();
    }
}
