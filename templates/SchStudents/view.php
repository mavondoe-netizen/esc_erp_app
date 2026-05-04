<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchStudent $schStudent
 */
?>
<div class="schStudent-profile">
    <!-- Header Profile Card -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="bg-primary py-5 px-4 d-flex align-items-center justify-content-between text-white">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar-large me-4 shadow-lg">
                        <?= strtoupper(substr($schStudent->user->name ?? 'S', 0, 1)) ?>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-0"><?= $schStudent->hasValue('user') ? h($schStudent->user->name) : 'Student Profile' ?></h1>
                        <p class="mb-0 opacity-75">Admission No: <span class="fw-bold"><?= h($schStudent->admission_no) ?></span> | Class: <?= $schStudent->hasValue('sch_class') ? h($schStudent->sch_class->name) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-primary rounded-pill px-4 py-2 fw-bold">ACTIVE STUDENT</span>
                    <div class="mt-2 text-white-50 small">Enrolled: <?= h($schStudent->created->format('d M, Y')) ?></div>
                </div>
            </div>
            
            <div class="nav-scroller bg-white border-bottom">
                <nav class="nav nav-underline px-4" aria-label="Secondary navigation">
                    <a class="nav-link active py-3 fw-bold me-4" href="#overview">Overview</a>
                    <a class="nav-link py-3 fw-bold me-4" href="#academics">Academic Records</a>
                    <a class="nav-link py-3 fw-bold me-4" href="#attendance">Attendance History</a>
                    <a class="nav-link py-3 fw-bold me-4 text-danger" href="#finance">Financial Status</a>
                </nav>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Sidebar: Personal Details -->
        <div class="column column-30">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Full Name</label>
                        <div class="fw-medium text-dark"><?= h($schStudent->user->name ?? 'N/A') ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Date of Birth</label>
                        <div class="fw-medium text-dark"><?= $schStudent->date_of_birth ? $schStudent->date_of_birth->format('d M Y') : 'N/A' ?></div>
                    </div>
                    <hr class="my-3 opacity-10">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Guardian Name</label>
                        <div class="fw-medium text-dark"><?= $schStudent->hasValue('contact') ? h($schStudent->contact->name) : h($schStudent->guardian_name ?: 'N/A') ?></div>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Guardian Phone</label>
                        <div class="fw-medium text-primary fw-bold"><?= $schStudent->hasValue('contact') ? h($schStudent->contact->mobile) : h($schStudent->guardian_phone ?: 'N/A') ?></div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <?= $this->Html->link(__('Edit Profile'), ['action' => 'edit', $schStudent->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        <?= $this->Html->link(__('Generate ID Card'), ['action' => 'view', $schStudent->id], ['class' => 'btn btn-outline-secondary btn-sm']) ?>
                        <?= $this->Html->link(__('Message Parent'), ['action' => 'view', $schStudent->id], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="column column-70">
            <!-- Academic Overview -->
            <div id="academics" class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>Academic Performance</h5>
                    <?= $this->Html->link(__('Report Card'), ['action' => 'reportCard', $schStudent->id], ['class' => 'btn btn-sm btn-primary', 'target' => '_blank']) ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 no-dt">
                            <thead class="bg-light small text-muted text-uppercase">
                                <tr>
                                    <th class="ps-4">Subject</th>
                                    <th>Exam Type</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th class="text-center pe-4">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($schStudent->sch_results)): ?>
                                    <?php foreach ($schStudent->sch_results as $result): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?= h($result->sch_subject->name) ?></td>
                                        <td class="small"><?= h($result->sch_exam->name) ?></td>
                                        <td>
                                            <div class="progress" style="height: 6px; width: 100px;">
                                                <div class="progress-bar bg-success" style="width: <?= $result->marks ?>%"></div>
                                            </div>
                                            <span class="small fw-bold mt-1 d-block"><?= $result->marks ?>%</span>
                                        </td>
                                        <td><span class="badge bg-soft-success text-success px-2 py-1"><?= h($result->grade) ?></span></td>
                                        <td class="text-center text-muted small"><?= h($result->created->format('d M y')) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-5 text-muted small italic">No examination results found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Financial Status -->
            <?php
                $totalBilled  = array_sum(array_map(fn($inv) => (float)$inv->total, $schStudent->invoices ?? []));
                $totalReceipted = array_sum(array_map(fn($rct) => (float)$rct->amount, $schStudent->receipts ?? []));
                $outstanding  = $totalBilled - $totalReceipted;
                $currency     = !empty($schStudent->invoices) ? $schStudent->invoices[0]->currency : 'USD';
            ?>
            <div id="finance" class="card border-0 shadow-sm border-start border-4 border-danger">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-wallet2 me-2"></i>Financial Statement</h5>
                    <div class="d-flex gap-2">
                        <?= $this->Html->link(
                            '<i class="bi bi-file-earmark-plus me-1"></i> New Invoice',
                            ['controller' => 'Invoices', 'action' => 'add', '?' => ['student_id' => $schStudent->id]],
                            ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
                        ) ?>
                        <?= $this->Html->link(
                            '<i class="bi bi-cash-coin me-1"></i> Record Receipt',
                            ['controller' => 'Receipts', 'action' => 'add', '?' => ['student_id' => $schStudent->id]],
                            ['class' => 'btn btn-sm btn-danger', 'escape' => false]
                        ) ?>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Summary Row -->
                    <div class="row text-center mb-4 g-3">
                        <div class="col-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <label class="text-muted small text-uppercase mb-1 d-block">Total Invoiced</label>
                                <h4 class="fw-bold mb-0 text-dark"><?= $currency ?> <?= number_format($totalBilled, 2) ?></h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <label class="text-muted small text-uppercase mb-1 d-block">Total Receipted</label>
                                <h4 class="fw-bold mb-0 text-success"><?= $currency ?> <?= number_format($totalReceipted, 2) ?></h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 <?= $outstanding > 0 ? 'bg-soft-danger' : 'bg-soft-success' ?> rounded-3 h-100">
                                <label class="<?= $outstanding > 0 ? 'text-danger' : 'text-success' ?> small text-uppercase mb-1 d-block">Outstanding Balance</label>
                                <h4 class="fw-bold mb-0 <?= $outstanding > 0 ? 'text-danger' : 'text-success' ?>"><?= $currency ?> <?= number_format(abs($outstanding), 2) ?><?= $outstanding < 0 ? ' <span class="fs-6">(Credit)</span>' : '' ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Invoices Table -->
                    <?php if (!empty($schStudent->invoices)): ?>
                    <h6 class="fw-bold text-muted text-uppercase small mb-2"><i class="bi bi-receipt me-1"></i>Invoice History</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover align-middle small mb-0 no-dt">
                            <thead class="bg-light text-muted text-uppercase" style="font-size: 0.72rem;">
                                <tr>
                                    <th class="ps-3">Ref #</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Currency</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schStudent->invoices as $invoice): ?>
                                <tr>
                                    <td class="ps-3 fw-bold">
                                        <?= $this->Html->link(
                                            h($invoice->reference ?? "INV-{$invoice->id}"),
                                            ['controller' => 'Invoices', 'action' => 'view', $invoice->id],
                                            ['class' => 'text-primary text-decoration-none']
                                        ) ?>
                                    </td>
                                    <td class="text-muted"><?= h($invoice->date->format('d M Y')) ?></td>
                                    <td><?= h($invoice->description) ?></td>
                                    <td><?= h($invoice->currency) ?></td>
                                    <td class="text-end fw-bold"><?= number_format((float)$invoice->total, 2) ?></td>
                                    <td class="text-center pe-3">
                                        <?php
                                            $statusClass = match(strtolower($invoice->status ?? '')) {
                                                'paid'     => 'bg-success',
                                                'overdue'  => 'bg-danger',
                                                'sent'     => 'bg-info',
                                                'approved' => 'bg-primary',
                                                default    => 'bg-secondary',
                                            };
                                        ?>
                                        <span class="badge <?= $statusClass ?> rounded-pill"><?= h($invoice->status) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    <!-- Receipts Table -->
                    <?php if (!empty($schStudent->receipts)): ?>
                    <h6 class="fw-bold text-muted text-uppercase small mb-2"><i class="bi bi-cash-stack me-1"></i>Receipt History</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small mb-0 no-dt">
                            <thead class="bg-light text-muted text-uppercase" style="font-size: 0.72rem;">
                                <tr>
                                    <th class="ps-3">Reference</th>
                                    <th>Date</th>
                                    <th>Mode</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schStudent->receipts as $receipt): ?>
                                <tr>
                                    <td class="ps-3 fw-bold">
                                        <?= $this->Html->link(
                                            h($receipt->reference ?? $receipt->manual_reference ?? "RCT-{$receipt->id}"),
                                            ['controller' => 'Receipts', 'action' => 'view', $receipt->id],
                                            ['class' => 'text-primary text-decoration-none']
                                        ) ?>
                                    </td>
                                    <td class="text-muted"><?= h($receipt->date ? (is_string($receipt->date) ? $receipt->date : $receipt->date->format('d M Y')) : '—') ?></td>
                                    <td><?= h($receipt->description ?? '—') ?></td>
                                    <td><?= h($receipt->currency) ?></td>
                                    <td>
                                        <?php
                                            $rctStatusClass = match(strtolower($receipt->status ?? '')) {
                                                'approved' => 'bg-success',
                                                'rejected' => 'bg-danger',
                                                'pending approval' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        ?>
                                        <span class="badge <?= $rctStatusClass ?> rounded-pill"><?= h($receipt->status) ?></span>
                                    </td>
                                    <td class="text-end fw-bold text-success pe-3"><?= number_format((float)$receipt->amount, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    <?php if (empty($schStudent->invoices) && empty($schStudent->receipts)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 opacity-25 d-block mb-2"></i>
                        <p class="mb-0">No financial records found. Create an invoice to get started.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%) !important; }
.profile-avatar-large {
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.2);
    border: 4px solid rgba(255,255,255,0.4);
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 900;
}
.nav-link { color: #64748b; border-bottom: 2px solid transparent; }
.nav-link.active { color: #4f46e5 !important; border-bottom-color: #4f46e5 !important; }
.bg-soft-success { background: #f0fdf4; color: #166534; }
.bg-soft-danger { background: #fef2f2; }
</style>
