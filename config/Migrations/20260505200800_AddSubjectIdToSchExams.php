<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddSubjectIdToSchExams extends BaseMigration
{
    public function change(): void
    {
        $this->table('sch_exams')
            ->addColumn('subject_id', 'integer', [
                'default' => null,
                'limit'   => 11,
                'null'    => true,
                'after'   => 'name',
            ])
            ->addIndex(['subject_id'])
            ->update();
    }
}
