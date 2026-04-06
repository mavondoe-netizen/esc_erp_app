<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddBankTxLinkToTransactions extends AbstractMigration
{
    /**
     * Up Method.
     *
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('transactions');
        $table->addColumn('bank_transaction_id', 'integer', [
            'null' => true,
            'default' => null,
            'after' => 'id'
        ])
        ->addIndex(['bank_transaction_id'])
        ->update();
    }

    /**
     * Down Method.
     *
     * @return void
     */
    public function down(): void
    {
        $table = $this->table('transactions');
        $table->removeColumn('bank_transaction_id')
            ->update();
    }
}
