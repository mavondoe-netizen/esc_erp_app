<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateAssetManagementTables extends AbstractMigration
{
    public function change(): void
    {
        // 1. asset_categories
        $table = $this->table('asset_categories');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('default_useful_life', 'integer', ['default' => null, 'null' => true, 'comment' => 'months'])
            ->addColumn('depreciation_method', 'string', ['limit' => 50, 'default' => 'straight_line', 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->create();

        // 2. asset_classifications
        $table = $this->table('asset_classifications');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 100, 'null' => false, 'comment' => 'PPE / Investment'])
            ->addColumn('accounting_treatment', 'text', ['default' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->create();

        // 3. offices
        $table = $this->table('offices');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('location', 'string', ['limit' => 255, 'default' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->create();

        // 4. assets
        $table = $this->table('assets');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_tag', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('category_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('classification_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('acquisition_date', 'date', ['default' => null, 'null' => true])
            ->addColumn('acquisition_cost', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => null, 'null' => true])
            ->addColumn('useful_life', 'integer', ['default' => null, 'null' => true, 'comment' => 'months'])
            ->addColumn('depreciation_method', 'string', ['limit' => 50, 'default' => 'straight_line', 'null' => false])
            ->addColumn('residual_value', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('current_book_value', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => null, 'null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'active', 'null' => false, 'comment' => 'active, disposed, under_repair'])
            ->addColumn('office_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('assigned_to', 'integer', ['default' => null, 'null' => true, 'comment' => 'user/employee id'])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_tag', 'company_id'], ['unique' => true])
            ->create();

        // 5. asset_depreciation
        $table = $this->table('asset_depreciation');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('period', 'string', ['limit' => 10, 'null' => false, 'comment' => 'YYYY-MM'])
            ->addColumn('depreciation_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('accumulated_depreciation', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('book_value', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('posted_to_ledger', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();

        // 6. asset_assignments
        $table = $this->table('asset_assignments');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('office_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('department_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('assigned_to', 'integer', ['default' => null, 'null' => true])
            ->addColumn('assigned_date', 'date', ['default' => null, 'null' => false])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'active', 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();

        // 7. asset_transfers
        $table = $this->table('asset_transfers');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('from_office_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('to_office_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('transfer_date', 'date', ['default' => null, 'null' => false])
            ->addColumn('approved_by', 'integer', ['default' => null, 'null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending', 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();

        // 8. asset_repairs
        $table = $this->table('asset_repairs');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('issue_description', 'text', ['null' => false])
            ->addColumn('repair_type', 'string', ['limit' => 50, 'default' => 'minor', 'null' => false, 'comment' => 'minor/major'])
            ->addColumn('vendor', 'string', ['limit' => 255, 'default' => null, 'null' => true])
            ->addColumn('cost', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('start_date', 'date', ['default' => null, 'null' => true])
            ->addColumn('end_date', 'date', ['default' => null, 'null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'default' => 'pending', 'null' => false])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();

        // 9. asset_disposals
        $table = $this->table('asset_disposals');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('disposal_type', 'string', ['limit' => 50, 'null' => false, 'comment' => 'sale, scrap, donation, write_off'])
            ->addColumn('disposal_date', 'date', ['default' => null, 'null' => false])
            ->addColumn('disposal_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00', 'null' => false])
            ->addColumn('gain_or_loss', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => null, 'null' => true])
            ->addColumn('approved_by', 'integer', ['default' => null, 'null' => true])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();

        // 10. asset_logs
        $table = $this->table('asset_logs');
        $table->addColumn('company_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('asset_id', 'integer', ['default' => null, 'null' => false])
            ->addColumn('action', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('user_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('timestamp', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('details', 'text', ['default' => null, 'null' => true])
            ->addIndex(['company_id'])
            ->addIndex(['asset_id'])
            ->create();
    }
}
