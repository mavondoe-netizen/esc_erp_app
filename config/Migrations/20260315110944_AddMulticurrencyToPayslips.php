<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddMulticurrencyToPayslips extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('payslips');
        $table->addColumn('exchange_rate', 'decimal', [
            'default' => 1.0000,
            'null' => false,
            'precision' => 15,
            'scale' => 4,
            'after' => 'net_pay'
        ]);
        
        $table->addColumn('usd_gross', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        $table->addColumn('usd_deductions', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        $table->addColumn('usd_net', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        
        $table->addColumn('zwg_gross', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        $table->addColumn('zwg_deductions', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        $table->addColumn('zwg_net', 'decimal', ['default' => 0.00, 'null' => false, 'precision' => 15, 'scale' => 2]);
        $table->update();

        $itemsTable = $this->table('payslip_items');
        $itemsTable->addColumn('currency', 'string', [
            'default' => 'ZWG',
            'limit' => 3,
            'null' => false,
            'after' => 'amount'
        ]);
        $itemsTable->update();
    }
}
