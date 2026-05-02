<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'ESCerp App - Premium ERP';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    
    <?= $this->Html->meta('icon') ?>
    
    <!-- Premium Design System -->
    <!-- Premium Design System -->
    <?= $this->Html->css(['premium', 'bulk_actions', 'sales_bot', 'quick-add']) ?>

    <!-- DataTables & Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <?php if (!empty($sandboxModeActive)): ?>
    <div style="background:linear-gradient(90deg,#f59e0b,#d97706); color:white; padding:8px 1.5rem; display:flex; align-items:center; gap:0.75rem; font-weight:700; font-size:0.9rem; position:sticky; top:0; z-index:9999; box-shadow:0 2px 8px rgba(217,119,6,0.5);">
        <i class="fa fa-flask"></i>
        ⚠ SANDBOX MODE ACTIVE — You are working with test data. Production is unaffected.
        <a href="<?= $this->Url->build(['controller' => 'Sandbox', 'action' => 'index']) ?>" style="margin-left:auto; color:white; background:rgba(0,0,0,0.15); padding:3px 14px; border-radius:20px; text-decoration:none; font-size:0.8rem;">Manage Sandbox</a>
    </div>
    <?php endif; ?>

    <?php if (!empty($isSuperAdmin) && !empty($switchedCompanyId)): ?>
    <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); color:white; padding:8px 1.5rem; display:flex; align-items:center; gap:0.75rem; font-weight:700; font-size:0.9rem; position:sticky; top:0; z-index:9998; box-shadow:0 2px 8px rgba(99,102,241,0.4);">
        <i class="fa fa-building"></i>
        👁 VIEWING AS: <em style="font-style:normal; background:rgba(255,255,255,0.2); padding:1px 10px; border-radius:20px;"><?= h($switchedCompanyName ?? 'Company #' . $switchedCompanyId) ?></em>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'exitCompanySwitch'], 'style' => 'margin-left:auto; display:inline;']) ?>
            <?= $this->Form->button('✕ Exit Company View', ['style' => 'background:rgba(255,255,255,0.2); color:white; border:none; padding:3px 14px; border-radius:20px; cursor:pointer; font-weight:700; font-size:0.8rem;']) ?>
        <?= $this->Form->end() ?>
    </div>
    <?php endif; ?>

    <div class="app-container">
        <!-- Top Navbar -->
        <header class="app-navbar">
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <?php if ($this->request->getAttribute('identity')): ?>
                    <?= $this->Html->link('<i class="fa fa-sign-out-alt"></i>', ['controller' => 'Users', 'action' => 'logout'], [
                        'escape' => false, 
                        'class' => 'logout-btn',
                        'title' => 'Logout'
                    ]) ?>
                <?php endif; ?>
                <div class="navbar-brand">
                    <a href="<?= $this->Url->build('/') ?>">ESCerp_app</a>
                </div>
            </div>
            <div class="navbar-search">
                <form method="get" action="<?= $this->Url->build(['controller' => 'Search', 'action' => 'index']) ?>" style="margin-0; display: flex; gap: 0.5rem;">
                    <input type="search" name="q" placeholder="Search everywhere..." aria-label="Search" style="margin: 0; width: 250px;">
                    <button type="submit" class="btn btn-primary" style="margin: 0;">Search</button>
                </form>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem; margin-left:auto; padding-right:0;">
                <?php if (!empty($isSuperAdmin)): ?>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'switchCompany'], 'style' => 'display:flex; align-items:center; gap:0.5rem;']) ?>
                        <label for="company-switcher" style="color:#64748b; font-size:0.82rem; white-space:nowrap; font-weight:600;">
                            <i class="fa fa-building"></i> View as:
                        </label>
                        <select id="company-switcher" name="company_id" class="no-s2" onchange="this.form.submit()"
                            style="padding:0.35rem 0.75rem; border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.82rem; background:#f8fafc; cursor:pointer; min-width:160px;">
                            <option value="">— My Company —</option>
                            <?php foreach ($allCompanies as $co): ?>
                            <?php
                                $coId   = is_array($co) ? ($co['id']   ?? '') : $co->id;
                                $coName = is_array($co) ? ($co['name'] ?? '') : $co->name;
                            ?>
                            <option value="<?= h($coId) ?>" <?= ($switchedCompanyId == $coId) ? 'selected' : '' ?>>
                                <?= h($coName) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    <?= $this->Form->end() ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($isAdminOrSuper)): ?>
                <a href="<?= $this->Url->build(['controller' => 'Sandbox', 'action' => 'index']) ?>" title="Sandbox Environment" style="color:#64748b; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:0.35rem;">
                    <i class="fa fa-flask"></i> Sandbox
                </a>
                <?php endif; ?>
            </div>
        </header>

        <div class="app-body">
            <!-- Sidebar -->
            <aside class="app-sidebar">
                <div class="sidebar-brand">
                    <i class="fas fa-th-large"></i>
                    <span>ESCerp</span>
                </div>
                <nav class="sidebar-nav">

                    <!-- Dashboard -->
                    <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" class="sidebar-link sidebar-home <?= ($this->request->getParam('controller') === 'Dashboard') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>

                    <?php
                    $ctrl = $this->request->getParam('controller');
                    $identity = $this->request->getAttribute('identity');

                    // Helper: detect if any of the given controllers is the current one
                    $groupActive = function(array $controllers) use ($ctrl) {
                        return in_array($ctrl, $controllers) ? 'open' : '';
                    };
                    ?>

                    <!-- ACCOUNTING -->
                    <?php $ga = $groupActive(['Transactions','BankTransactions','Accounts','ExchangeRates','Reports','ZimraReports','Budgets']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-calculator"></i> Accounting</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-list"></i> Transactions', ['controller' => 'Transactions', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Transactions' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-university"></i> Bank Reconciliation', ['controller' => 'BankTransactions', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'BankTransactions' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-book"></i> Chart of Accounts', ['controller' => 'Accounts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Accounts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-book-open"></i> Bulk Journals', '/transactions/bulk-add', ['escape' => false, 'class' => 'nav-sub-link']) ?>
                            <?= $this->Html->link('<i class="fas fa-chart-bar"></i> Reports', ['controller' => 'Reports', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Reports' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-landmark"></i> ZIMRA Tax Return', ['controller' => 'ZimraReports', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'ZimraReports' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-exchange-alt"></i> Exchange Rates', ['controller' => 'ExchangeRates', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'ExchangeRates' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-chart-pie"></i> Budgets', ['controller' => 'Budgets', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Budgets' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- LOANS -->
                    <?php $ga = $groupActive(['Loans','LoanApplications','LoanClients','LoanProducts','LoanSchedules','LoanRepayments','LoanDisbursements','LoanDeductions','LoanRestructures','LoanWriteoffs','DelinquencyFlags','ClientScores']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-hand-holding-usd"></i> Loans</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-tachometer-alt"></i> Loan Dashboard', ['controller' => 'Loans', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Loans' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-alt"></i> Applications', ['controller' => 'LoanApplications', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanApplications' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-users"></i> Loan Clients', ['controller' => 'LoanClients', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanClients' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-box"></i> Loan Products', ['controller' => 'LoanProducts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanProducts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-money-bill-wave"></i> Repayments', ['controller' => 'LoanRepayments', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanRepayments' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-paper-plane"></i> Disbursements', ['controller' => 'LoanDisbursements', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanDisbursements' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-exclamation-triangle"></i> Delinquency', ['controller' => 'DelinquencyFlags', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'DelinquencyFlags' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-sync-alt"></i> Restructures', ['controller' => 'LoanRestructures', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanRestructures' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-trash-alt"></i> Write-offs', ['controller' => 'LoanWriteoffs', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LoanWriteoffs' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-star"></i> Credit Scores', ['controller' => 'ClientScores', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'ClientScores' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- INVOICING / SALES -->
                    <?php $ga = $groupActive(['Invoices', 'Bills', 'Customers', 'Payments', 'Receipts', 'Estimates', 'DebitNotes', 'CreditNotes']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-file-invoice-dollar"></i> Invoicing</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-user-tie"></i> Customers', ['controller' => 'Customers', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Customers' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-invoice"></i> Invoices', ['controller' => 'Invoices', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Invoices' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-money-bill-wave"></i> Payments', ['controller' => 'Payments', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Payments' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-receipt"></i> Receipts', ['controller' => 'Receipts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Receipts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-alt"></i> Estimates/Quotes', ['controller' => 'Estimates', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Estimates' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-minus"></i> Credit Notes', ['controller' => 'CreditNotes', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'CreditNotes' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-plus"></i> Debit Notes', ['controller' => 'DebitNotes', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'DebitNotes' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- CRM -->
                    <?php $ga = $groupActive(['Customers','Suppliers','Contacts','Deals','DealRequests','Tasks','Meetings','Events']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-users"></i> CRM</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-user-tie"></i> Customers', ['controller' => 'Customers', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Customers' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-truck"></i> Suppliers', ['controller' => 'Suppliers', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Suppliers' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-address-book"></i> Contacts', ['controller' => 'Contacts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Contacts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-handshake"></i> Deals', ['controller' => 'Deals', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Deals' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-tasks"></i> Tasks', ['controller' => 'Tasks', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Tasks' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-calendar-alt"></i> Meetings', ['controller' => 'Meetings', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Meetings' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-calendar-day"></i> Events', ['controller' => 'Events', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Events' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- PAYROLL -->
                    <?php $ga = $groupActive(['Payslips','PayPeriods','Employees','SalaryStructures','Earnings','Deductions','TaxTables','ZimraReconciliations','LeaveApplications','LeaveBalances','LeaveTypes','EmployeeProfiles']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-money-check-alt"></i> Payroll</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-file-signature"></i> Payslips', ['controller' => 'Payslips', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Payslips' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-calendar-week"></i> Pay Periods', ['controller' => 'PayPeriods', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'PayPeriods' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-users-cog"></i> Employees', ['controller' => 'Employees', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Employees' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-sitemap"></i> Salary Structures', ['controller' => 'SalaryStructures', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'SalaryStructures' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-plus-circle"></i> Earnings', ['controller' => 'Earnings', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Earnings' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-minus-circle"></i> Deductions', ['controller' => 'Deductions', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Deductions' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-percent"></i> Tax Tables', ['controller' => 'TaxTables', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'TaxTables' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-balance-scale-left"></i> ZIMRA Reconciliations', ['controller' => 'ZimraReconciliations', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'ZimraReconciliations' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-umbrella-beach"></i> Leave Applications', ['controller' => 'LeaveApplications', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LeaveApplications' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-balance-scale"></i> Leave Balances', ['controller' => 'LeaveBalances', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LeaveBalances' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- PROPERTIES -->
                    <?php $ga = $groupActive(['Buildings','Units','Tenants','Enrolments','LeasePayments','Levies','Repairs','Inspections']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-building"></i> Properties</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-city"></i> Buildings', ['controller' => 'Buildings', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Buildings' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-door-open"></i> Units', ['controller' => 'Units', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Units' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-user-friends"></i> Tenants', ['controller' => 'Tenants', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Tenants' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-contract"></i> Leases', ['controller' => 'Enrolments', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Enrolments' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-hand-holding-usd"></i> Rental Payments', ['controller' => 'LeasePayments', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'LeasePayments' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-tags"></i> Levies', ['controller' => 'Levies', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Levies' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-tools"></i> Repairs', ['controller' => 'Repairs', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Repairs' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-clipboard-check"></i> Inspections', ['controller' => 'Inspections', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Inspections' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- PROCUREMENT -->
                    <?php $ga = $groupActive(['Requisitions','Procurements','Tenders','TenderBids','Evaluations','Awards','Contracts','GoodsReceipts']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-shopping-cart"></i> Procurement</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-file-invoice"></i> Requisitions', ['controller' => 'Requisitions', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Requisitions' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-briefcase"></i> Procurement Cases', ['controller' => 'Procurements', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Procurements' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-gavel"></i> Tenders', ['controller' => 'Tenders', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Tenders' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-contract"></i> Tender Bids', ['controller' => 'TenderBids', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'TenderBids' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-poll"></i> Evaluations', ['controller' => 'Evaluations', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Evaluations' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-award"></i> Awards', ['controller' => 'Awards', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Awards' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-signature"></i> Contracts', ['controller' => 'Contracts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Contracts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-truck-loading"></i> Goods Receipts', ['controller' => 'GoodsReceipts', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'GoodsReceipts' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-invoice"></i> Bills (Supplier Invoices)', ['controller' => 'Bills', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Bills' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- INVENTORY / PRODUCTS -->
                    <?php $ga = $groupActive(['Products','Bills','BillItems']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-boxes"></i> Inventory</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-box-open"></i> Products', ['controller' => 'Products', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Products' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- ASSET MANAGEMENT -->
                    <?php $ga = $groupActive(['Assets','AssetCategories','AssetClassifications','Offices','AssetDepreciation','AssetAssignments','AssetTransfers','AssetRepairs','AssetDisposals','AssetLogs']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-cubes"></i> Asset Management</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-list-alt"></i> Master Register', ['controller' => 'Assets', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Assets' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-map-marker-alt"></i> Offices', ['controller' => 'Offices', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Offices' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-chart-line"></i> Depreciation', ['controller' => 'AssetDepreciation', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AssetDepreciation' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-exchange-alt"></i> Transfers', ['controller' => 'AssetTransfers', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AssetTransfers' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-tools"></i> Repairs', ['controller' => 'AssetRepairs', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AssetRepairs' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-trash-alt"></i> Disposals', ['controller' => 'AssetDisposals', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AssetDisposals' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-cogs"></i> Configuration', ['controller' => 'AssetCategories', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AssetCategories' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- RISK & COMPLIANCE -->
                    <?php $ga = $groupActive(['Risks','RiskAssessments','Kris','AuditPlans','Audits','AuditFindings','AuditActions','Regulations','ComplianceObligations','ComplianceChecks','Incidents','LossEvents','Controls','ControlTests','Documents']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-shield-alt"></i> Risk & Compliance</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-exclamation-triangle"></i> Risk Register', ['controller' => 'Risks', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Risks' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-clipboard-check"></i> Audit Plans', ['controller' => 'AuditPlans', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'AuditPlans' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-clipboard-list"></i> Audits', ['controller' => 'Audits', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Audits' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-book"></i> Regulations', ['controller' => 'Regulations', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Regulations' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-bell"></i> Incidents', ['controller' => 'Incidents', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Incidents' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-lock"></i> Controls', ['controller' => 'Controls', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Controls' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-file-pdf"></i> Documents', ['controller' => 'Documents', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Documents' ? ' active' : '')]) ?>
                        </div>
                    </div>

                    <!-- ADMIN -->
                    <?php $ga = $groupActive(['Users','Roles','Permissions','Companies','Departments','Modules','ApprovalFlows','ApprovalLevels','Backups','Settings']); ?>
                    <div class="nav-group <?= $ga ?>">
                        <div class="nav-group-header" onclick="toggleGroup(this)">
                            <span><i class="fas fa-cogs"></i> Admin</span>
                            <i class="fas fa-chevron-down nav-arrow"></i>
                        </div>
                        <div class="nav-group-body">
                            <?= $this->Html->link('<i class="fas fa-user-shield"></i> Users', ['controller' => 'Users', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Users' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-user-tag"></i> Roles', ['controller' => 'Roles', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Roles' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-lock"></i> Permissions', ['controller' => 'Permissions', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Permissions' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-sitemap"></i> Departments', ['controller' => 'Departments', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Departments' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-puzzle-piece"></i> Modules', ['controller' => 'Modules', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Modules' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-project-diagram"></i> Approval Flows', ['controller' => 'ApprovalFlows', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'ApprovalFlows' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-database"></i> Database Backups', ['controller' => 'Backups', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Backups' ? ' active' : '')]) ?>
                            <?= $this->Html->link('<i class="fas fa-cog"></i> Server Settings', ['controller' => 'Settings', 'action' => 'index'], ['escape' => false, 'class' => 'nav-sub-link' . ($ctrl === 'Settings' ? ' active' : '')]) ?>
                            <?php if (!empty($isAdminOrSuper)): ?>
                            <a href="<?= $this->Url->build('/sandbox') ?>" class="nav-sub-link"><i class="fas fa-flask"></i> Sandbox</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- MY PORTAL (if linked employee) -->
                    <?php if ($identity && !empty($identity->employee_id)): ?>
                    <a href="<?= $this->Url->build('/portal/dashboard') ?>" class="sidebar-link <?= ($ctrl === 'Portal') ? 'active' : '' ?>">
                        <i class="fas fa-id-card"></i> <span>My Portal</span>
                    </a>
                    <?php endif; ?>

                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="app-content">
                <style>
                    .message { 
                        padding: 1rem 1.5rem; 
                        margin-bottom: 2rem; 
                        border-radius: 8px; 
                        font-weight: 500; 
                        cursor: pointer; 
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05); 
                        transition: opacity 0.3s;
                    }
                    .message.success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
                    .message.error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
                    .message.info { background-color: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
                    .message.hidden { display: none; }
                </style>
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </main>
        </div>
    </div>

    <!-- Floating Bulk Action Bar -->
    <div id="bulk-action-bar" class="bulk-action-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-layer-group"></i>
            <span class="bulk-count">0</span> items selected
        </div>
        <div class="bulk-actions-btns">
            <button id="bulk-edit-btn" class="bulk-btn">
                <i class="fas fa-edit"></i> Bulk Set Value
            </button>
            <button id="bulk-delete-btn" class="bulk-btn danger">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
        <button id="bulk-close-btn" class="button button-clear" style="color: white; margin: 0; padding: 5px;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Bulk Update Modal -->
    <div id="bulk-update-modal" class="bulk-modal-overlay">
        <div class="bulk-modal">
            <h3><i class="fas fa-edit"></i> Bulk Set Value</h3>
            <p>Apply a new value to all selected records.</p>
            <div class="bulk-field-group">
                <label>Target Field</label>
                <select id="bulk-field-select">
                    <option value="">Loading updatable fields...</option>
                </select>
            </div>
            <div class="bulk-field-group" id="bulk-value-container">
                <label>New Value</label>
                <input type="text" id="bulk-value-input" placeholder="Enter new value">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button id="bulk-cancel-modal" class="button button-outline">Cancel</button>
                <button id="bulk-confirm-update" class="button">Apply to All</button>
            </div>
        </div>
    </div>

    <!-- jQuery, DataTables, & Buttons JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?= $this->fetch('script') ?>
    
    <!-- Grouped Sidebar Toggle -->
    <script>
    function toggleGroup(header) {
        const group = header.parentElement;
        group.classList.toggle('open');
    }
    // Auto-open any pre-marked open groups on load (no animation flash)
    document.querySelectorAll('.nav-group.open .nav-group-body').forEach(function(el) {
        el.style.display = 'block';
    });
    </script>

    <!-- Global Bulk & DataTables Logic -->
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrfToken"]').attr('content');
            
            // Initialize Select2 on selects unless they opt-out
            $('select:not(.no-s2)').each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).attr('placeholder') || 'Select an option',
                    allowClear: true
                });
            });

            // Build correct controller base URL for both root and subdirectory installs
            const appBase = '<?= rtrim($this->Url->build('/'), '/') ?>';
            const pathParts = window.location.pathname.replace(appBase, '').split('/').filter(p => p !== '');
            const controllerUrl = appBase + (pathParts.length > 0 ? '/' + pathParts[0] : '');
            
            // 1. Initialize Datatables with custom settings
            let table = $('table:has(thead):not(.no-dt)').DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                order: [], // Default no initial sort to preserve logical order
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                    {
                        text: '<i class="fas fa-file-upload"></i> Import CSV',
                        action: function ( e, dt, node, config ) { $('#global-import-input').click(); }
                    },
                    {
                        text: '<i class="fas fa-file-download"></i> Download Template',
                        action: function ( e, dt, node, config ) { 
                            window.location.href = controllerUrl + '/download-template'; 
                        }
                    }
                ]
            });

            // 2. Selection Logic
            const bulkBar = $('#bulk-action-bar');
            const bulkCount = $('.bulk-count');
            
            function updateSelectionStatus() {
                const selected = $('.row-checkbox:checked');
                bulkCount.text(selected.length);
                if (selected.length > 0) bulkBar.addClass('active');
                else bulkBar.removeClass('active');
            }

            $(document).on('change', '.row-checkbox', function() {
                $(this).closest('tr').toggleClass('selected', this.checked);
                updateSelectionStatus();
            });

            $(document).on('change', '#select-all-rows', function() {
                $('.row-checkbox').prop('checked', this.checked).trigger('change');
            });

            $('#bulk-close-btn').click(function() {
                $('.row-checkbox').prop('checked', false).trigger('change');
            });

            // 3. Bulk Delete
            $('#bulk-delete-btn').click(function() {
                const selectedIds = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
                if (!confirm(`Are you sure you want to delete ${selectedIds.length} selected records?`)) return;

                $.ajax({
                    url: controllerUrl + '/bulk-action',
                    type: 'POST',
                    data: { ids: selectedIds, action: 'delete' },
                    headers: { 'X-CSRF-Token': csrfToken },
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            window.location.reload();
                        } else alert('Error: ' + res.message);
                    }
                });
            });

            // 4. Bulk Edit Modal Loading
            let bulkUpdatableFields = [];
            $('#bulk-edit-btn').click(function() {
                $('#bulk-update-modal').css('display', 'flex');
                
                // Fetch fields only once per page load
                if ($('#bulk-field-select').children().length <= 1) {
                    $.get(controllerUrl + '/api-get-bulk-options', function(res) {
                        if (res.success) {
                            bulkUpdatableFields = res.fields;
                            const select = $('#bulk-field-select').html('<option value="">-- Select Field --</option>');
                            res.fields.forEach(f => {
                                select.append(`<option value="${f.field}">${f.label}</option>`);
                            });
                        }
                    });
                }
            });

            $('#bulk-cancel-modal').click(function() { $('#bulk-update-modal').hide(); });

            // Handle Value Input Type based on field type
            $('#bulk-field-select').change(function() {
                const fieldName = $(this).val();
                const field = bulkUpdatableFields.find(f => f.field === fieldName);
                if (!field) return;

                const container = $('#bulk-value-container').html(`<label>New Value for ${field.label}</label>`);
                
                if (field.type === 'boolean') {
                    container.append(`<select id="bulk-value-input">
                        <option value="1">YES / True</option>
                        <option value="0">NO / False</option>
                    </select>`);
                } else if (field.type === 'date') {
                    container.append(`<input type="date" id="bulk-value-input">`);
                } else if (field.type === 'decimal' || field.type === 'integer') {
                    container.append(`<input type="number" id="bulk-value-input" step="any">`);
                } else {
                    container.append(`<input type="text" id="bulk-value-input" placeholder="Enter new value">`);
                }
            });

            // 5. Bulk Update Submission
            $('#bulk-confirm-update').click(function() {
                const selectedIds = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
                const field = $('#bulk-field-select').val();
                const value = $('#bulk-value-input').val();

                if (!field) return alert('Please select a field to update.');
                if (!confirm(`Apply this change to ${selectedIds.length} records?`)) return;

                $.ajax({
                    url: controllerUrl + '/bulk-action',
                    type: 'POST',
                    data: { ids: selectedIds, action: 'update', field: field, value: value },
                    headers: { 'X-CSRF-Token': csrfToken },
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            window.location.reload();
                        } else alert('Error: ' + res.message);
                    }
                });
            });

            // Handle the hidden generic CSV import input
            $('#global-import-input').on('change', function() {
                if (this.files.length > 0 && controllerUrl !== '') {
                    if(!confirm('Are you sure you want to import data into ' + controllerUrl + '?')) return;
                    
                    let formData = new FormData();
                    formData.append('import_file', this.files[0]);
                    
                    $.ajax({
                        url: controllerUrl + '/import',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: { 'X-CSRF-Token': csrfToken },
                        success: function(response) {
                            alert(response.message || 'Import successful! Page will refresh.');
                            window.location.reload();
                        },
                        error: function(xhr) {
                            const res = xhr.responseJSON;
                            let msg = res?.message || 'Import failed. Please check server logs.';
                            
                            if (res?.errors && res.errors.length > 0) {
                                msg += "\n\nValidation Details:\n" + res.errors.slice(0, 15).join("\n");
                                if (res.errors.length > 15) {
                                    msg += "\n... and " + (res.errors.length - 15) + " more errors.";
                                }
                            }
                            alert(msg);
                        }
                    });
                }
            });
        });
    </script>

    <!-- Hidden Generic Import Form -->
    <input type="file" id="global-import-input" accept=".csv" style="display: none;">

    <!-- Interactive Sales Bot Widget -->
    <div class="sales-bot-container">
        <div id="sales-bot-bubble" class="sales-bot-bubble">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div id="sales-bot-window" class="sales-bot-window">
            <div class="sales-bot-header">
                <h4><i class="fas fa-robot"></i> ESCerp Assistant</h4>
                <div id="sales-bot-close" style="cursor:pointer; font-size: 1.2em;">&times;</div>
            </div>
            <div id="sales-bot-messages" class="sales-bot-messages">
                <!-- Messages populate here -->
                <div id="bot-typing" class="bot-typing">Assistant is typing...</div>
            </div>
            <div class="sales-bot-input-area">
                <input type="text" id="sales-bot-input" placeholder="Type a message..." autocomplete="off">
                <button id="sales-bot-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bot logic -->
    <script>
        window.BotConfig = {
            company_id: <?= (int)$currentCompanyId ?>,
            baseUrl: '<?= rtrim($this->Url->build('/'), '/') ?>'
        };
    </script>
    <?= $this->Html->script('sales_bot') ?>
    <!-- Global Quick Add Modal -->
    <div id="globalQuickAddModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
       <div style="background:#fff; width:80%; height:80%; max-width:800px; border-radius:8px; display:flex; flex-direction:column; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
           <div style="padding:15px 20px; background:#f4f4f4; border-bottom:1px solid #ddd; display:flex; justify-content:space-between; align-items:center;">
               <h4 style="margin:0;">Quick Add Record</h4>
               <button type="button" class="button button-clear" onclick="document.getElementById('globalQuickAddModal').style.display='none'; document.getElementById('globalQuickAddIframe').src='';" style="padding:0; margin:0; font-size:1.5em; line-height:1; color:#dc3545;">&times;</button>
           </div>
           <iframe id="globalQuickAddIframe" style="flex-grow:1; border:none; width:100%;" src=""></iframe>
       </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle trigger clicks
        document.body.addEventListener('click', function(e) {
            if (e.target.matches('.global-quick-add-btn') || e.target.closest('.global-quick-add-btn')) {
                const btn = e.target.matches('.global-quick-add-btn') ? e.target : e.target.closest('.global-quick-add-btn');
                let url = btn.getAttribute('data-url');
                const targetDropdownId = btn.getAttribute('data-target-dropdown');
                
                // Store target locally on the modal so message listener knows where to inject
                const modal = document.getElementById('globalQuickAddModal');
                modal.setAttribute('data-active-dropdown', targetDropdownId);

                const appBase = '<?= rtrim($this->Url->build('/'), '/') ?>';
                if (url && url.startsWith('/') && appBase !== '') {
                    url = appBase + url;
                }
                
                document.getElementById('globalQuickAddIframe').src = url;
                modal.style.display = 'flex';
            }
        });

        // Listen for iframe success callback
        window.addEventListener('message', function(event) {
            if (event.data && event.data.action === 'itemAdded') {
                const modal = document.getElementById('globalQuickAddModal');
                modal.style.display = 'none';
                document.getElementById('globalQuickAddIframe').src = '';
                
                const dropdownId = modal.getAttribute('data-active-dropdown');
                if (dropdownId) {
                    const dropdown = document.getElementById(dropdownId);
                    if (dropdown) {
                        const newOption = new Option(event.data.name, event.data.id, true, true);
                        if (typeof $ !== 'undefined' && $(dropdown).hasClass('select2-hidden-accessible')) {
                            $(dropdown).append(newOption).trigger('change');
                        } else {
                            dropdown.add(newOption);
                            dropdown.value = event.data.id;
                        }
                    }
                }
            }
        });
    });
    </script>
</body>
</html>
