<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateClientScores extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('client_scores');
        $t->addColumn('client_id', 'integer', ['null' => false])
          ->addColumn('score', 'integer', ['default' => 0]) // 0-1000
          ->addColumn('grade', 'string', ['limit' => 5, 'null' => true]) // A B C D E
          ->addColumn('risk_level', 'string', ['limit' => 20, 'null' => true]) // low | medium | high | very_high
          ->addColumn('debt_ratio', 'decimal', ['precision' => 8, 'scale' => 4, 'null' => true])
          ->addColumn('repayment_history_score', 'decimal', ['precision' => 8, 'scale' => 4, 'null' => true])
          ->addColumn('delinquency_score', 'decimal', ['precision' => 8, 'scale' => 4, 'null' => true])
          ->addColumn('active_loans_count', 'integer', ['default' => 0])
          ->addColumn('computed_at', 'datetime', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
