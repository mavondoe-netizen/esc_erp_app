<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddNameFieldsToSchStudents extends BaseMigration
{
    public function change(): void
    {
        $this->table('sch_students')
            ->addColumn('first_name', 'string', [
                'limit'   => 100,
                'null'    => true,
                'default' => null,
                'after'   => 'admission_no',
            ])
            ->addColumn('last_name', 'string', [
                'limit'   => 100,
                'null'    => true,
                'default' => null,
                'after'   => 'first_name',
            ])
            ->addColumn('gender', 'string', [
                'limit'   => 10,
                'null'    => true,
                'default' => null,
                'after'   => 'last_name',
            ])
            ->update();
    }
}
