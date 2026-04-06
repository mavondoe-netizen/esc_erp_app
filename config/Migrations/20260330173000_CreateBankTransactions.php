<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateBankTransactions extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('bank_transactions');
        $table->addColumn('company_id', 'integer', ['null' => false])
            ->addColumn('date', 'date', ['null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('reference', 'string', ['limit' => 151, 'null' => true])
            ->addColumn('reconciled', 'boolean', ['default' => false])
            ->addColumn('transaction_id', 'integer', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['company_id'])
            ->addIndex(['reconciled'])
            ->create();

        $tableRules = $this->table('bank_rules');
        $tableRules->addColumn('company_id', 'integer', ['null' => false])
            ->addColumn('match_text', 'string', ['limit' => 151, 'null' => false])
            ->addColumn('account_id', 'integer', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['company_id'])
            ->create();
    }

    /**
     * Down Method.
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('bank_transactions')->drop()->save();
        $this->table('bank_rules')->drop()->save();
    }
}
