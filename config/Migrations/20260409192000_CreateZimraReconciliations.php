<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateZimraReconciliations extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('zimra_reconciliations');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('employee_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('pay_period_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('payroll_tax_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('assessed_tax_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('variance', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending', 'null' => false])
            ->addColumn('cleared_date', 'date', ['default' => null, 'null' => true])
            ->addColumn('cleared_via', 'string', ['limit' => 255, 'default' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['employee_id'])
            ->addIndex(['pay_period_id'])
            // Only one recon per employee per period
            ->addIndex(['company_id', 'employee_id', 'pay_period_id'], ['unique' => true, 'name' => 'idx_unique_zimra_recon'])
            ->create();
    }
}
