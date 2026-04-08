<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanDeductions extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_deductions');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('employee_id', 'integer', ['null' => false])
          ->addColumn('monthly_amount', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('status', 'string', ['limit' => 20, 'default' => 'active']) // active | suspended | completed
          ->addColumn('start_date', 'date', ['null' => true])
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
