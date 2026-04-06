<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddBankAccountIdToBankTransactions extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('bank_transactions');
        $table->addColumn('bank_account_id', 'integer', [
            'null' => true, // Nullable initially for safety, but we'll enforce it in UI
            'after' => 'company_id'
        ])
        ->addIndex(['bank_account_id'])
        ->update();
    }

    /**
     * Down Method.
     *
     * @return void
     */
    public function down(): void
    {
        $table = $this->table('bank_transactions');
        $table->removeColumn('bank_account_id')
            ->update();
    }
}
