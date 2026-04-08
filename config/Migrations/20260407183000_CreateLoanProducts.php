<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanProducts extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_products');
        $t->addColumn('company_id', 'integer', ['null' => true])
          ->addColumn('name', 'string', ['limit' => 200])
          ->addColumn('code', 'string', ['limit' => 50, 'null' => true])
          ->addColumn('interest_rate', 'decimal', ['precision' => 8, 'scale' => 4, 'default' => '0.0000'])
          ->addColumn('interest_method', 'string', ['limit' => 20, 'default' => 'reducing']) // flat | reducing
          ->addColumn('repayment_frequency', 'string', ['limit' => 20, 'default' => 'monthly']) // monthly | weekly | fortnightly
          ->addColumn('min_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('max_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('max_term', 'integer', ['default' => 12])
          ->addColumn('min_term', 'integer', ['default' => 1])
          ->addColumn('grace_period_days', 'integer', ['default' => 0])
          ->addColumn('penalty_rate', 'decimal', ['precision' => 8, 'scale' => 4, 'default' => '0.0000'])
          ->addColumn('requires_guarantor', 'boolean', ['default' => false])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('is_active', 'boolean', ['default' => true])
          ->addColumn('description', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
