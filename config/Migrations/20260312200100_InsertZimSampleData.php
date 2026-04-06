<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class InsertZimSampleData extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        
        // Ensure tax_tables has currency USD and ZWL etc if we need, let's just insert 2024 USD brackets
        // 0-100: 0% rate, 0 deduction
        // 101-300: 20% rate, 20 deduction
        // 301-1000: 25% rate, 35 deduction
        // 1001-2000: 30% rate, 85 deduction
        // 2001-3000: 35% rate, 185 deduction
        // 3001+: 40% rate, 335 deduction
        $taxTables = [
            ['currency' => 'USD', 'lower_limit' => 0, 'upper_limit' => 100, 'rate' => 0, 'deduction' => 0, 'tax_year' => '2024-01-01'],
            ['currency' => 'USD', 'lower_limit' => 101, 'upper_limit' => 300, 'rate' => 20, 'deduction' => 20, 'tax_year' => '2024-01-01'],
            ['currency' => 'USD', 'lower_limit' => 301, 'upper_limit' => 1000, 'rate' => 25, 'deduction' => 35, 'tax_year' => '2024-01-01'],
            ['currency' => 'USD', 'lower_limit' => 1001, 'upper_limit' => 2000, 'rate' => 30, 'deduction' => 85, 'tax_year' => '2024-01-01'],
            ['currency' => 'USD', 'lower_limit' => 2001, 'upper_limit' => 3000, 'rate' => 35, 'deduction' => 185, 'tax_year' => '2024-01-01'],
            ['currency' => 'USD', 'lower_limit' => 3001, 'upper_limit' => 9999999, 'rate' => 40, 'deduction' => 335, 'tax_year' => '2024-01-01'],
        ];

        // Ensure we clear out old sample ones if desired, or just insert
        $this->execute('DELETE FROM tax_tables WHERE currency = \'USD\' AND tax_year = \'2024-01-01\'');

        $this->table('tax_tables')->insert($taxTables)->saveData();

        // Insert sample Account if not exists to tie earnings to
        $accountId = 1;
        $accountCheck = $this->query('SELECT id FROM accounts LIMIT 1')->fetch();
        if (!$accountCheck) {
            $this->table('accounts')->insert([[
                'name' => 'Payroll Account',
                'type' => 'Asset',
                'balance' => 0
            ]])->saveData();
            $accountId = $this->query('SELECT id FROM accounts ORDER BY id DESC LIMIT 1')->fetch()[0];
        } else {
            $accountId = $accountCheck[0];
        }

        // Earnings
        $earnings = [
            ['name' => 'Basic Salary', 'account_id' => $accountId, 'taxable' => 1, 'pensionable' => 1, 'nssa_applicable' => 1, 'calculation_type' => 'Fixed'],
            ['name' => 'Transport Allowance', 'account_id' => $accountId, 'taxable' => 1, 'pensionable' => 0, 'nssa_applicable' => 0, 'calculation_type' => 'Fixed'],
            ['name' => 'Housing Allowance', 'account_id' => $accountId, 'taxable' => 1, 'pensionable' => 0, 'nssa_applicable' => 0, 'calculation_type' => 'Fixed'],
            ['name' => 'COLA', 'account_id' => $accountId, 'taxable' => 1, 'pensionable' => 1, 'nssa_applicable' => 1, 'calculation_type' => 'Fixed'],
        ];
        
        $this->execute('DELETE FROM earnings');
        $this->table('earnings')->insert($earnings)->saveData();

        // Deductions
        $deductions = [
            ['name' => 'Medical Aid', 'statutory' => 0, 'tax_deductible' => 1, 'calculation_type' => 'Fixed'],
            ['name' => 'Pension Fund', 'statutory' => 0, 'tax_deductible' => 1, 'calculation_type' => 'Percentage'],
            ['name' => 'Advance Repayment', 'statutory' => 0, 'tax_deductible' => 0, 'calculation_type' => 'Fixed'],
        ];
        
        $this->execute('DELETE FROM deductions');
        $this->table('deductions')->insert($deductions)->saveData();

        // Add a sample employee if no employees exist
        $employeeCheck = $this->query('SELECT id FROM employees LIMIT 1')->fetch();
        if (!$employeeCheck) {
            $this->table('employees')->insert([[
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+263771234567',
                'hire_date' => '2023-01-01',
                'status' => 'Active'
            ]])->saveData();
        }
    }

    public function down(): void
    {
        // Not strictly required for sample data
    }
}
