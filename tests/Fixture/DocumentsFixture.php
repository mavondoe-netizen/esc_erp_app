<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 */
class DocumentsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'company_id' => 1,
                'entity_type' => 'Lorem ipsum dolor sit amet',
                'entity_id' => 1,
                'file_path' => 'Lorem ipsum dolor sit amet',
                'file_name' => 'Lorem ipsum dolor sit amet',
                'uploaded_by' => 1,
                'uploaded_at' => '2026-04-08 16:37:10',
                'created' => '2026-04-08 16:37:10',
                'modified' => '2026-04-08 16:37:10',
            ],
        ];
        parent::init();
    }
}
