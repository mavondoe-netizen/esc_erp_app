<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class UpdateBillItemsForProducts extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('bill_items');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('company_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('vat_rate', 'decimal', [
            'default' => 0,
            'precision' => 10,
            'scale' => 6,
            'null' => false,
        ]);
        $table->addColumn('vat_type', 'string', [
            'default' => 'Standard',
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('hs_code', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->update();
    }
}
