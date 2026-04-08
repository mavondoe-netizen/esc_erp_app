<?php
declare(strict_types=1);
use Migrations\AbstractMigration;

class CreateLoanClients extends AbstractMigration
{
    public function change(): void
    {
        $t = $this->table('loan_clients');
        $t->addColumn('company_id', 'integer', ['null' => true])
          ->addColumn('employee_id', 'integer', ['null' => true])
          ->addColumn('name', 'string', ['limit' => 200])
          ->addColumn('national_id', 'string', ['limit' => 100, 'null' => true])
          ->addColumn('dob', 'date', ['null' => true])
          ->addColumn('gender', 'string', ['limit' => 20, 'null' => true])
          ->addColumn('employer_name', 'string', ['limit' => 200, 'null' => true])
          ->addColumn('employment_type', 'string', ['limit' => 50, 'null' => true]) // permanent | contract | self_employed
          ->addColumn('monthly_income', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => '0.00'])
          ->addColumn('income_currency', 'string', ['limit' => 10, 'default' => 'USD'])
          ->addColumn('contact_phone', 'string', ['limit' => 50, 'null' => true])
          ->addColumn('contact_email', 'string', ['limit' => 200, 'null' => true])
          ->addColumn('address', 'text', ['null' => true])
          ->addColumn('status', 'string', ['limit' => 30, 'default' => 'active']) // active | blacklisted | inactive
          ->addColumn('notes', 'text', ['null' => true])
          ->addColumn('created', 'datetime', ['null' => true])
          ->addColumn('modified', 'datetime', ['null' => true])
          ->create();
    }
}
