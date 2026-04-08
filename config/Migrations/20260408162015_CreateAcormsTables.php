<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateAcormsTables extends AbstractMigration
{
    public function up(): void
    {
        $tables = [
            'documents', 'control_tests', 'controls', 'loss_events', 'incidents',
            'compliance_checks', 'compliance_obligations', 'regulations',
            'audit_actions', 'audit_findings', 'audits', 'audit_plans',
            'kris', 'risk_assessments', 'risks'
        ];
        foreach ($tables as $t) {
            if ($this->hasTable($t)) {
                $this->table($t)->drop()->save();
            }
        }

        // RISKS
        $table = $this->table('risks');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('category', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('business_unit_id', 'integer', ['null' => true])
            ->addColumn('owner_id', 'integer', ['null' => true])
            ->addColumn('inherent_risk_score', 'decimal', ['precision' => 5, 'scale' => 2, 'null' => true, 'default' => 0])
            ->addColumn('residual_risk_score', 'decimal', ['precision' => 5, 'scale' => 2, 'null' => true, 'default' => 0])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => true, 'default' => 'Open'])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // RISK ASSESSMENTS
        $table = $this->table('risk_assessments');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('risk_id', 'integer', ['null' => false])
            ->addColumn('likelihood', 'integer', ['null' => false])
            ->addColumn('impact', 'integer', ['null' => false])
            ->addColumn('control_effectiveness', 'integer', ['null' => false])
            ->addColumn('risk_rating', 'decimal', ['precision' => 5, 'scale' => 2, 'null' => false])
            ->addColumn('assessed_by', 'integer', ['null' => true])
            ->addColumn('assessed_at', 'datetime', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // KEY RISK INDICATORS
        $table = $this->table('kris');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('risk_id', 'integer', ['null' => false])
            ->addColumn('metric', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('threshold', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
            ->addColumn('current_value', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false, 'default' => 'normal'])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // AUDIT PLANS
        $table = $this->table('audit_plans');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('year', 'integer', ['null' => false])
            ->addColumn('business_unit_id', 'integer', ['null' => true])
            ->addColumn('audit_type', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('planned_start', 'date', ['null' => true])
            ->addColumn('planned_end', 'date', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // AUDITS
        $table = $this->table('audits');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('audit_plan_id', 'integer', ['null' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('scope', 'text', ['null' => true])
            ->addColumn('auditor_id', 'integer', ['null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false, 'default' => 'Planned'])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // AUDIT FINDINGS
        $table = $this->table('audit_findings');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('audit_id', 'integer', ['null' => false])
            ->addColumn('finding', 'text', ['null' => false])
            ->addColumn('risk_level', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('root_cause', 'text', ['null' => true])
            ->addColumn('recommendation', 'text', ['null' => true])
            ->addColumn('management_response', 'text', ['null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false, 'default' => 'Open'])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // AUDIT ACTIONS
        $table = $this->table('audit_actions');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('finding_id', 'integer', ['null' => false])
            ->addColumn('assigned_to', 'integer', ['null' => true])
            ->addColumn('due_date', 'date', ['null' => true])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false, 'default' => 'Pending'])
            ->addColumn('completion_date', 'date', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // REGULATIONS
        $table = $this->table('regulations');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('regulator', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // COMPLIANCE OBLIGATIONS
        $table = $this->table('compliance_obligations');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('regulation_id', 'integer', ['null' => false])
            ->addColumn('requirement', 'text', ['null' => false])
            ->addColumn('frequency', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('owner_id', 'integer', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // COMPLIANCE CHECKS
        $table = $this->table('compliance_checks');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('obligation_id', 'integer', ['null' => false])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('evidence', 'text', ['null' => true])
            ->addColumn('checked_at', 'datetime', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // INCIDENTS
        $table = $this->table('incidents');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('type', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('business_unit_id', 'integer', ['null' => true])
            ->addColumn('reported_by', 'integer', ['null' => true])
            ->addColumn('reported_at', 'datetime', ['null' => true])
            ->addColumn('severity', 'string', ['limit' => 50, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // LOSS EVENTS
        $table = $this->table('loss_events');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('incident_id', 'integer', ['null' => false])
            ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false, 'default' => 0])
            ->addColumn('recovery_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true, 'default' => 0])
            ->addColumn('net_loss', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true, 'default' => 0])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // CONTROLS
        $table = $this->table('controls');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('risk_id', 'integer', ['null' => true])
            ->addColumn('control_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('control_type', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('frequency', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('owner_id', 'integer', ['null' => true])
            ->addColumn('effectiveness_rating', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // CONTROL TESTS
        $table = $this->table('control_tests');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('control_id', 'integer', ['null' => false])
            ->addColumn('test_result', 'text', ['null' => true])
            ->addColumn('tested_by', 'integer', ['null' => true])
            ->addColumn('tested_at', 'datetime', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();

        // DOCUMENTS (Polymorphic)
        $table = $this->table('documents');
        $table->addColumn('company_id', 'integer', ['null' => true])
            ->addColumn('entity_type', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('entity_id', 'integer', ['null' => false])
            ->addColumn('file_path', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('file_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('uploaded_by', 'integer', ['null' => true])
            ->addColumn('uploaded_at', 'datetime', ['null' => true])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();
            
        // DROPPING WRONG TABLE IF IT EXISTS from bake creation
        if ($this->hasTable('acorms_tables')) {
            $this->table('acorms_tables')->drop()->save();
        }

        // Seed Roles
        $rolesData = [
            ['name' => 'Risk Officer'],
            ['name' => 'Auditor'],
            ['name' => 'Compliance Officer'],
            ['name' => 'Business Unit Head']
        ];
        $this->table('roles')->insert($rolesData)->save();
    }

    public function down(): void
    {
        $tables = [
            'documents', 'control_tests', 'controls', 'loss_events', 'incidents',
            'compliance_checks', 'compliance_obligations', 'regulations',
            'audit_actions', 'audit_findings', 'audits', 'audit_plans',
            'kris', 'risk_assessments', 'risks'
        ];
        foreach ($tables as $t) {
            if ($this->hasTable($t)) {
                $this->table($t)->drop()->save();
            }
        }
    }
}
