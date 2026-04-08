<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateDelinquencyFlags extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('delinquency_flags');
        $t->addColumn('loan_id', 'integer', ['null' => false])
          ->addColumn('days_overdue', 'integer', ['default' => 0])
          ->addColumn('amount_overdue', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('category', 'string', ['limit' => 20, 'default' => 'watch']) // watch | at_risk | delinquent | default
          ->addColumn('flagged_at', 'datetime', ['null' => true])
          ->addColumn('resolved_at', 'datetime', ['null' => true])
          ->addColumn('notification_sent', 'boolean', ['default' => false])
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
