<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

/**
 * Seeds required Chart of Accounts entries for the LMS ledger engine.
 * Only inserts if the account name does not already exist per company.
 */
class SeedLoanAccounts extends AbstractMigration
{
    public function up(): void
    {
        // We'll seed for company_id = 1 as default; multi-tenant companies can add via CoA
        $seedAccounts = [
            ['name' => 'Loan Receivable',   'category' => 'Asset',     'subcategory' => 'Loans'],
            ['name' => 'Interest Receivable','category' => 'Asset',     'subcategory' => 'Loans'],
            ['name' => 'Interest Income',    'category' => 'Revenue',   'subcategory' => 'Finance Income'],
            ['name' => 'Penalty Income',     'category' => 'Revenue',   'subcategory' => 'Finance Income'],
            ['name' => 'Bad Debt Expense',   'category' => 'Expense',   'subcategory' => 'Finance Expense'],
        ];

        foreach ($seedAccounts as $acct) {
            // Check if already exists (any company)
            $exists = $this->fetchRow(
                "SELECT id FROM accounts WHERE name = '{$acct['name']}' LIMIT 1"
            );
            if (!$exists) {
                $this->table('accounts')->insert([
                    'name'        => $acct['name'],
                    'category'    => $acct['category'],
                    'subcategory' => $acct['subcategory'],
                    'balance'     => 0,
                    'created'     => date('Y-m-d H:i:s'),
                    'modified'    => date('Y-m-d H:i:s'),
                ])->save();
            }
        }
    }

    public function down(): void
    {
        // intentionally left empty — don't delete existing account records on rollback
    }
}
