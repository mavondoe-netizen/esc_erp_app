<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanApplications extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_applications');
        $t->addColumn('company_id', 'integer', ['null' => true])
          ->addColumn('client_id', 'integer', ['null' => false])
          ->addColumn('loan_product_id', 'integer', ['null' => false])
          ->addColumn('amount_requested', 'decimal', ['precision' => 15, 'scale' => 2])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('term', 'integer', ['null' => false, 'comment' => 'in months'])
          ->addColumn('purpose', 'string', ['limit' => 255, 'null' => true])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'draft']) // draft | submitted | under_review | approved | rejected | cancelled
          ->addColumn('submitted_at', 'datetime', ['null' => true])
          ->addColumn('decided_at', 'datetime', ['null' => true])
          ->addColumn('decided_by', 'integer', ['null' => true])
          ->addColumn('rejection_reason', 'text', ['null' => true])
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
