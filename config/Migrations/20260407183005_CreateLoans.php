<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoans extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loans');
        $t->addColumn('company_id', 'integer', ['null' => true])
          ->addColumn('client_id', 'integer', ['null' => false])
          ->addColumn('loan_application_id', 'integer', ['null' => true])
          ->addColumn('loan_product_id', 'integer', ['null' => true])
          ->addColumn('loan_account_no', 'string', ['limit' => 50, 'null' => true])
          ->addColumn('principal', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('outstanding_balance', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('interest_rate', 'decimal', ['precision' => 8, 'scale' => 4])
          ->addColumn('interest_method', 'string', ['limit' => 20, 'default' => 'reducing'])
          ->addColumn('repayment_frequency', 'string', ['limit' => 20, 'default' => 'monthly'])
          ->addColumn('term', 'integer', ['null' => false])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('start_date', 'date', ['null' => true])
          ->addColumn('maturity_date', 'date', ['null' => true])
          ->addColumn('disbursed_at', 'datetime', ['null' => true])
          ->addColumn('last_payment_date', 'date', ['null' => true])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'pending_disbursement'])
            // pending_disbursement | active | closed | delinquent | written_off
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
