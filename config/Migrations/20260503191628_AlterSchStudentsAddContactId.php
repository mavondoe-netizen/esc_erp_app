<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlterSchStudentsAddContactId extends BaseMigration
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
        $table = $this->table('sch_students');
        $table->renameColumn('guardian_user_id', 'contact_id');
        $table->update();
    }
}
