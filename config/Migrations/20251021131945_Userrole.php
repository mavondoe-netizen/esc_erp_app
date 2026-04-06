<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Userrole extends AbstractMigration
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
        $usersTable = $this->table('Users');
        $usersTable->addColumn('role_id', 'integer',[
            'default' => null,
            'null' => true,
        ]);
        $usersTable->update();

    }
}
