<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $outstandingInvoices
 * @var iterable $outstandingFees
 */
?>
<div class="alerts-receivables content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger mb-1"><i class="bi bi-bell-fill me-2"></i><?= __('Receivables Alert System') ?></h2>
            <p class="text-muted small">Monitor all outstanding balances across ERP and School Management modules.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold">
                TOTAL PENDING: <?= count($outstandingInvoices) + count($outstandingFees) ?>
            </span>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="column column-50">
            <div class="card border-0 shadow-sm bg-primary text-white h-100 overflow-hidden position-relative">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <h6 class="text-white-50 small text-uppercase fw-bold mb-3">ERP Invoices</h6>
                    <h2 class="fw-bold mb-0"><?= count($outstandingInvoices) ?> <span class="fs-6 opacity-75 fw-normal">Outstanding</span></h2>
                    <p class="mt-2 mb-0 small opacity-75">Customer receivables pending payment.</p>
                </div>
                <i class="bi bi-file-earmark-text position-absolute" style="right: -10px; bottom: -20px; font-size: 6rem; opacity: 0.1;"></i>
            </div>
        </div>
        <div class="column column-50">
            <div class="card border-0 shadow-sm bg-indigo text-white h-100 overflow-hidden position-relative">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <h6 class="text-white-50 small text-uppercase fw-bold mb-3">School Fees</h6>
                    <h2 class="fw-bold mb-0"><?= count($outstandingFees) ?> <span class="fs-6 opacity-75 fw-normal">Unpaid</span></h2>
                    <p class="mt-2 mb-0 small opacity-75">Student fees pending settlement.</p>
                </div>
                <i class="bi bi-mortarboard position-absolute" style="right: -10px; bottom: -20px; font-size: 6rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>

    <!-- Tabs for Detailed View -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-0 p-0">
            <ul class="nav nav-tabs nav-justified border-0" id="receivableTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active py-3 fw-bold border-0 border-bottom border-3" id="invoices-tab" data-bs-toggle="tab" href="#invoices" role="tab">
                        <i class="bi bi-receipt me-2"></i>Customer Invoices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom border-3" id="fees-tab" data-bs-toggle="tab" href="#fees" role="tab">
                        <i class="bi bi-wallet2 me-2"></i>Student School Fees
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content" id="receivableTabsContent">
                <!-- Invoices Tab -->
                <div class="tab-pane fade show active" id="invoices" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 no-dt">
                            <thead class="bg-light small text-muted text-uppercase">
                                <tr>
                                    <th class="ps-4">Invoice #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($outstandingInvoices as $invoice): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">#<?= h($invoice->reference ?: $invoice->id) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-primary"><?= h($invoice->customer->name) ?></div>
                                    </td>
                                    <td class="text-muted small"><?= h($invoice->date) ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $invoice->currency ?> <?= number_format($invoice->total, 2) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-warning text-warning rounded-pill px-3"><?= h($invoice->status) ?></span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?= $this->Form->postLink(__('Send Reminder'), ['action' => 'triggerAlert'], [
                                                'data' => ['type' => 'invoice', 'id' => $invoice->id, 'target' => $invoice->customer->name],
                                                'class' => 'btn btn-xs btn-outline-danger shadow-sm'
                                            ]) ?>
                                            <?= $this->Html->link(__('Generate Notice'), ['action' => 'overdueNotice', '?' => ['type' => 'invoice', 'id' => $invoice->id]], ['class' => 'btn btn-xs btn-danger', 'target' => '_blank']) ?>
                                            <?= $this->Form->create(null, ['url' => ['action' => 'applyInterest'], 'class' => 'd-flex align-items-center gap-1']) ?>
                                                <?= $this->Form->hidden('type', ['value' => 'invoice']) ?>
                                                <?= $this->Form->hidden('id', ['value' => $invoice->id]) ?>
                                                <div style="width: 60px;">
                                                    <?= $this->Form->number('rate', ['value' => 10, 'class' => 'form-control form-control-xs px-1', 'style' => 'font-size: 0.7rem; height: 24px;']) ?>
                                                </div>
                                                <button type="submit" class="btn btn-xs btn-outline-primary" onclick="return confirm('Apply this interest rate penalty?')">
                                                    Apply %
                                                </button>
                                            <?= $this->Form->end() ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($outstandingInvoices) === 0): ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted small">No outstanding invoices found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Fees Tab -->
                <div class="tab-pane fade" id="fees" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 no-dt">
                            <thead class="bg-light small text-muted text-uppercase">
                                <tr>
                                    <th class="ps-4">Student</th>
                                    <th>Admission #</th>
                                    <th>Amount Due</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th class="text-center pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($outstandingFees as $fee): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?= h($fee->sch_student->user->name) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">#<?= h($fee->sch_student->admission_no) ?></span>
                                    </td>
                                    <td class="text-muted">$<?= number_format($fee->amount, 2) ?></td>
                                    <td class="text-success">$<?= number_format($fee->paid ?: 0, 2) ?></td>
                                    <td>
                                        <div class="fw-bold text-danger">$<?= number_format($fee->amount - ($fee->paid ?: 0), 2) ?></div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?= $this->Form->postLink(__('Alert Parent'), ['action' => 'triggerAlert'], [
                                                'data' => ['type' => 'fee', 'id' => $fee->id, 'target' => $fee->sch_student->guardian_name ?: $fee->sch_student->user->name],
                                                'class' => 'btn btn-xs btn-outline-danger shadow-sm'
                                            ]) ?>
                                            <?= $this->Html->link(__('Generate Notice'), ['action' => 'overdueNotice', '?' => ['type' => 'fee', 'id' => $fee->id]], ['class' => 'btn btn-xs btn-danger', 'target' => '_blank']) ?>
                                            <?= $this->Form->create(null, ['url' => ['action' => 'applyInterest'], 'class' => 'd-flex align-items-center gap-1']) ?>
                                                <?= $this->Form->hidden('type', ['value' => 'fee']) ?>
                                                <?= $this->Form->hidden('id', ['value' => $fee->id]) ?>
                                                <div style="width: 60px;">
                                                    <?= $this->Form->number('rate', ['value' => 10, 'class' => 'form-control form-control-xs px-1', 'style' => 'font-size: 0.7rem; height: 24px;']) ?>
                                                </div>
                                                <button type="submit" class="btn btn-xs btn-outline-primary" onclick="return confirm('Apply this interest rate penalty to this student?')">
                                                    Apply %
                                                </button>
                                            <?= $this->Form->end() ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (count($outstandingFees) === 0): ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted small">All school fees are settled.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-indigo { background-color: #6610f2 !important; }
.bg-soft-danger { background: #fee2e2; }
.bg-soft-warning { background: #fef3c7; }
.nav-tabs .nav-link { color: #64748b; border-bottom: 3px solid transparent; }
.nav-tabs .nav-link.active { color: #dc3545 !important; border-bottom-color: #dc3545 !important; background: transparent; }
.nav-tabs .nav-link:hover { background: #f8fafc; }
</style>
