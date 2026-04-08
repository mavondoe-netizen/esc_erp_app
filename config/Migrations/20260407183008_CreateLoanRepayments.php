<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanRepayments extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_repayments');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('client_id', 'integer', ['null' => true])
          ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('source', 'string', ['limit' => 30, 'default' => 'cash']) // cash | payroll | bank_transfer
          ->addColumn('payment_date', 'date', ['null' => false])
          ->addColumn('penalty_paid', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('interest_paid', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('principal_paid', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('reference', 'string', ['limit' => 150, 'null' => true])
          ->addColumn('account_id', 'integer', ['null' => true, 'comment' => 'Account receiving funds'])
          ->addColumn('processed_by', 'integer', ['null' => true])
          ->addColumn('allocation_json', 'text', ['null' => true])
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
