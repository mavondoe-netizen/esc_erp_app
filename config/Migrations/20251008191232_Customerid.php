<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Customerid extends AbstractMigration
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
                $table = $this->table('transactions');

        // Adds a new column 'customer_id' (integer, nullable)
        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'supplier_id', // optional, controls placement
        ])
        ->addIndex(['customer_id']) // optional index for performance
        ->update();
    }
    
}
