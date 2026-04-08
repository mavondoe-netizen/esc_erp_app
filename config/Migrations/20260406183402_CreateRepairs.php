<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRepairs extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('repairs');
        $table->addColumn('company_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('unit_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('building_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('tenant_id', 'integer', ['null' => true, 'limit' => 11]);
        $table->addColumn('title', 'string', ['null' => false, 'limit' => 200]);
        $table->addColumn('description', 'text', ['null' => true]);
        $table->addColumn('category', 'string', ['null' => true, 'limit' => 100]);
        $table->addColumn('status', 'string', ['null' => false, 'limit' => 50, 'default' => 'Reported']);
        $table->addColumn('reported_date', 'date', ['null' => true]);
        $table->addColumn('resolved_date', 'date', ['null' => true]);
        $table->addColumn('cost', 'decimal', ['null' => true, 'precision' => 15, 'scale' => 2]);
        $table->addColumn('currency', 'string', ['null' => true, 'limit' => 10, 'default' => 'USD']);
        $table->addColumn('account_id', 'integer', ['null' => true, 'limit' => 11, 'comment' => 'Maintenance expense account']);
        $table->addColumn('created', 'datetime', ['null' => true]);
        $table->addColumn('modified', 'datetime', ['null' => true]);
        $table->create();
    }
}
