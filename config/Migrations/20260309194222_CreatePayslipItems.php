<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePayslipItems extends AbstractMigration
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
        $table = $this->table('payslip_items');
        $table->addColumn('payslip_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('item_type', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('amount', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->create();
    }
}
