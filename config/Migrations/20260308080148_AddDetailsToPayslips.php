<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddDetailsToPayslips extends AbstractMigration
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
        $table = $this->table('payslips');
        $table->addColumn('basic_salary', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('allowances', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('bonuses', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('overtime', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('benefits', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('pension', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('nssa', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('medical_aid', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('medical_expenses', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('taxable_income', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('paye', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('tax_credits', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('aids_levy', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->addColumn('total_tax', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 6,
        ]);
        $table->update();
    }
}
