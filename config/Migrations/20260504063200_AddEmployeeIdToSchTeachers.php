<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddEmployeeIdToSchTeachers extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('sch_teachers');
        $table->addColumn('employee_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => true,
            'after'   => 'user_id',
        ]);
        $table->addIndex(['employee_id']);
        $table->update();
    }
}
