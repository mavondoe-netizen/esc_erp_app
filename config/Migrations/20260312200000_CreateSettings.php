<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSettings extends AbstractMigration
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
        $table = $this->table('settings');
        $table->addColumn('nssa_ceiling', 'decimal', [
            'default' => '700.00',
            'null' => false,
            'precision' => 10,
            'scale' => 2,
        ]);
        $table->addColumn('nssa_rate', 'decimal', [
            'default' => '4.50',
            'null' => false,
            'precision' => 5,
            'scale' => 2,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();

        // Insert default settings
        $table->insert([
            [
                'nssa_ceiling' => 700.00,
                'nssa_rate' => 4.50,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ]);
        $table->saveData();
    }
}
