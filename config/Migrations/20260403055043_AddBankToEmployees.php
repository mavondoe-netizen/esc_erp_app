<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddBankToEmployees extends AbstractMigration
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
        $table = $this->table('employees');
        $table->addColumn('usd_bank', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('usd_branch', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('usd_account', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('zwg_bank', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('zwg_branch', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);
        $table->addColumn('zwg_account', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->update();
    }
}
