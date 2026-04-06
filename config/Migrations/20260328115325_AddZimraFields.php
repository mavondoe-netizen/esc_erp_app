<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddZimraFields extends AbstractMigration
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
        $table->addColumn('zimra_mapping', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->update();

        $table = $this->table('deductions');
        $table->addColumn('zimra_mapping', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->update();

        $table = $this->table('employees');
        $table->addColumn('is_blind', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->update();
    }
}
