<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanSchedules extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_schedules');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('period_number', 'integer', ['null' => false])
          ->addColumn('due_date', 'date', ['null' => false])
          ->addColumn('principal_due', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('interest_due', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('penalty_due', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('total_due', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('amount_paid', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('balance', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('status', 'string', ['limit' => 20, 'default' => 'pending']) // pending | paid | overdue | partial
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->addIndex(['loan_id'])
          ->create();
    }
}
