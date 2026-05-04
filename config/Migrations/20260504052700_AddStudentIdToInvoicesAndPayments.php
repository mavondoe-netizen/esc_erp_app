<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddStudentIdToInvoicesAndPayments extends BaseMigration
{
    public function change(): void
    {
        // Add student_id to invoices table
        $invoicesTable = $this->table('invoices');
        $invoicesTable->addColumn('student_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => true,
            'after'   => 'customer_id',
        ]);
        $invoicesTable->addIndex(['student_id']);
        $invoicesTable->update();

        // Add student_id to receipts table (customer fee receipts)
        $receiptsTable = $this->table('receipts');
        $receiptsTable->addColumn('student_id', 'integer', [
            'default' => null,
            'limit'   => 11,
            'null'    => true,
            'after'   => 'customer_id',
        ]);
        $receiptsTable->addIndex(['student_id']);
        $receiptsTable->update();
    }
}
