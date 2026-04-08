<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLevies extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('levies');
        $table->addColumn('company_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('enrolment_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('tenant_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('unit_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('building_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('levy_type', 'string', ['null' => false, 'limit' => 100, 'default' => 'Maintenance']);
        $table->addColumn('amount', 'decimal', ['null' => false, 'default' => '0.00', 'precision' => 15, 'scale' => 2]);
        $table->addColumn('currency', 'string', ['null' => false, 'default' => 'USD', 'limit' => 10]);
        $table->addColumn('due_date', 'date', ['null' => true]);
        $table->addColumn('paid', 'boolean', ['null' => false, 'default' => false]);
        $table->addColumn('paid_date', 'date', ['null' => true]);
        $table->addColumn('account_id', 'integer', ['null' => true, 'limit' => 11, 'comment' => 'Bank account when paid']);
        $table->addColumn('description', 'text', ['null' => true]);
        $table->addColumn('created', 'datetime', ['null' => true]);
        $table->addColumn('modified', 'datetime', ['null' => true]);
        $table->create();
    }
}
