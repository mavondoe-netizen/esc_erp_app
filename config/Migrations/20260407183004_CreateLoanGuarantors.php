<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanGuarantors extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_guarantors');
        $t->addColumn('loan_application_id', 'integer', ['null' => false])
          ->addColumn('name', 'string', ['limit' => 200])
          ->addColumn('national_id', 'string', ['limit' => 100, 'null' => true])
          ->addColumn('relationship', 'string', ['limit' => 100, 'null' => true])
          ->addColumn('phone', 'string', ['limit' => 50, 'null' => true])
          ->addColumn('employer', 'string', ['limit' => 200, 'null' => true])
          ->addColumn('monthly_income', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'pending']) // pending | confirmed | declined
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
