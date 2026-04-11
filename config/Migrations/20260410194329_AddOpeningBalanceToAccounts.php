<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddOpeningBalanceToAccounts extends AbstractMigration
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
        $table = $this->table('accounts');
        $table->addColumn('opening_balance', 'decimal', [
            'default' => 0,
            'precision' => 15,
            'scale' => 2,
            'null' => false,
        ]);
        $table->update();
    }
}
