<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanRestructures extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_restructures');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('old_term', 'integer', ['null' => true])
          ->addColumn('new_term', 'integer', ['null' => false])
          ->addColumn('old_rate', 'decimal', ['precision' => 8, 'scale' => 4, 'null' => true])
          ->addColumn('new_rate', 'decimal', ['precision' => 8, 'scale' => 4, 'null' => true])
          ->addColumn('outstanding_at_restructure', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true])
          ->addColumn('reason', 'text', ['null' => true])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'pending']) // pending | approved | rejected
          ->addColumn('approved_by', 'integer', ['null' => true])
          ->addColumn('approved_at', 'datetime', ['null' => true])
          ->addColumn('effective_date', 'date', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
