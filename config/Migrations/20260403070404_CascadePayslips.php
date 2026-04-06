<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CascadePayslips extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        // Alter payslips table
        $this->table('payslips')
            ->dropForeignKey('pay_period_id')
            ->update();

        $this->table('payslips')
            ->addForeignKey('pay_period_id', 'pay_periods', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->update();

        // Alter payslip_items table omitted because no restricted constraint exists
    }

    public function down(): void
    {
        // Revert to RESTRICT/NO ACTION (default)
        $this->table('payslips')
            ->dropForeignKey('pay_period_id')
            ->update();

        $this->table('payslips')
            ->addForeignKey('pay_period_id', 'pay_periods', 'id', [
                'delete' => 'RESTRICT',
                'update' => 'CASCADE'
            ])
            ->update();

    }
}
