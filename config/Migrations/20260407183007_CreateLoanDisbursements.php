<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanDisbursements extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_disbursements');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('method', 'string', ['limit' => 30, 'default' => 'bank']) // bank | cash | payroll
          ->addColumn('bank_reference', 'string', ['limit' => 200, 'null' => true])
          ->addColumn('account_id', 'integer', ['null' => true, 'comment' => 'Bank/Cash account drawn from'])
          ->addColumn('disbursed_by', 'integer', ['null' => true])
          ->addColumn('disbursed_at', 'datetime', ['null' => true])
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
