<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Reports Dashboard');
?>
<div class="reports index content">
    <h3><?= __('Reports Dashboard') ?></h3>
    <p class="text-muted">Welcome to the advanced reporting suite. Select a report generator below.</p>

    <div class="row mt-4">
        <!-- ZIMRA PAYE -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #0b5394; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">ZIMRA PAYE Return</h4>
                    <p class="card-text text-muted">Generate the mandated P2 Form Employer's Monthly Schedule for statutory tax remittance.</p>
                    <?= $this->Html->link(__('Open ZIMRA Report'), ['action' => 'zimraPaye'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Income Statement -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #38761d; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Income Statement</h4>
                    <p class="card-text text-muted">Standard Profit & Loss layout summarizing Revenue, Cost of Sales, and Operating Expenses.</p>
                    <?= $this->Html->link(__('Open Income Statement'), ['action' => 'incomeStatement'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Balance Sheet -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #bf9000; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Statement of Financial Position</h4>
                    <p class="card-text text-muted">Cumulative Balance Sheet mapping Assets, Liabilities, and dynamically calculated Equity.</p>
                    <?= $this->Html->link(__('Open Balance Sheet'), ['action' => 'balanceSheet'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #cc0000; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Statement of Cash Flows</h4>
                    <p class="card-text text-muted">Indirect method tracking working capital variances across Operating, Investing, and Financing flows.</p>
                    <?= $this->Html->link(__('Open Cash Flow'), ['action' => 'cashFlow'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Agnostic Builder -->
        <div class="col-md-12 mb-4">
            <div class="card" style="border-left: 5px solid #674ea7; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background: #fbf9ff;">
                <div class="card-body">
                    <h4 class="card-title">Agnostic Report Builder (Drag & Drop)</h4>
                    <p class="card-text text-muted">A dynamic data studio that allows you to construct and print custom tabular layouts from any module in the system framework.</p>
                    <?= $this->Html->link(__('Launch Data Studio Builder'), ['action' => 'builder'], ['class' => 'button']) ?>
                </div>
            </div>
        </div>

        <!-- Trial Balance -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #4a90e2; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Trial Balance</h4>
                    <p class="card-text text-muted">A summary of the balances of all ledger accounts to verify that total debits equal total credits.</p>
                    <?= $this->Html->link(__('Open Trial Balance'), ['action' => 'trialBalance'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Bank Schedule -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #134f5c; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Bank Transfer Schedule</h4>
                    <p class="card-text text-muted">Automatically groups employee net pays by their assigned banking routing details based on target fiat currency.</p>
                    <?= $this->Html->link(__('Open Bank Schedule'), ['action' => 'bankSchedule'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Receivables Aging -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #2563eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Receivables Aging</h4>
                    <p class="card-text text-muted">Detailed aged analysis of outstanding customer invoices (0-30, 31-60, 61-90, 90+ days).</p>
                    <?= $this->Html->link(__('Open Receivables Aging'), ['action' => 'receivablesAging'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Payables Aging -->
        <div class="col-md-6 mb-4">
            <div class="card" style="border-left: 5px solid #dc2626; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h4 class="card-title">Payables Aging</h4>
                    <p class="card-text text-muted">Detailed aged analysis of outstanding supplier bills and liabilities.</p>
                    <?= $this->Html->link(__('Open Payables Aging'), ['action' => 'payablesAging'], ['class' => 'button button-outline']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
