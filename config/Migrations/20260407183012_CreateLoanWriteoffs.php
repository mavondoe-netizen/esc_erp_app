<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanWriteoffs extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_writeoffs');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('outstanding_at_writeoff', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true])
          ->addColumn('reason', 'text', ['null' => true])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'pending']) // pending | approved | rejected
          ->addColumn('approved_by', 'integer', ['null' => true])
          ->addColumn('approved_at', 'datetime', ['null' => true])
          ->addColumn('account_id', 'integer', ['null' => true, 'comment' => 'Bad Debt Expense account'])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
