<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLeasePayments extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('lease_payments');
        $table->addColumn('company_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('enrolment_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('tenant_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('unit_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('building_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('account_id', 'integer', ['null' => true, 'limit' => 11, 'comment' => 'Cash/Bank account receiving payment']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'default' => '0.00', 'precision' => 15, 'scale' => 2]);
        $table->addColumn('currency', 'string', ['null' => false, 'default' => 'USD', 'limit' => 10]);
        $table->addColumn('payment_mode', 'string', ['null' => true, 'limit' => 50]);
        $table->addColumn('reference', 'string', ['null' => true, 'limit' => 150]);
        $table->addColumn('period_covered', 'string', ['null' => true, 'limit' => 50, 'comment' => 'e.g. April 2026']);
        $table->addColumn('date', 'date', ['null' => false]);
        $table->addColumn('description', 'text', ['null' => true]);
        $table->addColumn('created', 'datetime', ['null' => true]);
        $table->addColumn('modified', 'datetime', ['null' => true]);
        $table->create();
    }
}
