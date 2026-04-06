<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddAdvancedTaxFieldsToEarnings extends AbstractMigration
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
        $table = $this->table('earnings');
        $table->addColumn('gross_up', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('taxable_percentage', 'decimal', [
            'default' => '100.00',
            'null' => false,
            'precision' => 5,
            'scale' => 2,
        ]);
        $table->addColumn('tax_free_amount', 'decimal', [
            'default' => '0.00',
            'null' => false,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->update();
    }
}
