<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchStudent $schStudent
 */

// Resolve display name — first/last → user name → fallback
$displayName = trim(($schStudent->first_name ?? '') . ' ' . ($schStudent->last_name ?? ''));
if (!$displayName) $displayName = $schStudent->user->name ?? 'Student Profile';
$initial = strtoupper(substr($displayName, 0, 1));

// Financial totals
$totalBilled    = array_sum(array_map(fn($i) => (float)$i->total,  $schStudent->invoices ?? []));
$totalReceipted = array_sum(array_map(fn($r) => (float)$r->amount, $schStudent->receipts ?? []));
$outstanding    = $totalBilled - $totalReceipted;
$currency       = !empty($schStudent->invoices) ? ($schStudent->invoices[0]->currency ?? 'USD') : 'USD';
?>

<!-- ── PROFILE HERO ─────────────────────────────────────────────────── -->
<div class="card border-0 shadow-sm mb-4 overflow-hidden">
    <div style="background: linear-gradient(135deg,#4f46e5,#3b82f6); padding: 2rem 2rem 0;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-4">
            <div class="d-flex align-items-center gap-4">
                <!-- Avatar -->
                <div style="width:90px;height:90px;background:rgba(255,255,255,0.18);border:3px solid rgba(255,255,255,0.35);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:2.2rem;font-weight:900;color:#fff;flex-shrink:0;">
                    <?= $initial ?>
                </div>
                <div class="text-white">
                    <h2 class="fw-bold mb-1"><?= h($displayName) ?></h2>
                    <div class="d-flex align-items-center gap-3 flex-wrap" style="opacity:.85;font-size:.9rem;">
                        <span><i class="fas fa-id-badge me-1"></i><?= h($schStudent->admission_no) ?></span>
                        <span>•</span>
                        <span><i class="fas fa-school me-1"></i><?= $schStudent->hasValue('sch_class') ? h($schStudent->sch_class->name) : 'No Class' ?></span>
                        <?php if ($schStudent->gender): ?>
                        <span>•</span>
                        <span><i class="fas fa-venus-mars me-1"></i><?= h($schStudent->gender) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <?= $this->Html->link('<i class="fas fa-edit me-1"></i>Edit Profile', ['action' => 'edit', $schStudent->id], ['class' => 'btn btn-light fw-bold', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fas fa-file-invoice me-1"></i>New Invoice', ['controller' => 'Invoices', 'action' => 'add', '?' => ['student_id' => $schStudent->id]], ['class' => 'btn btn-warning fw-bold', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fas fa-receipt me-1"></i>Record Receipt', ['controller' => 'Receipts', 'action' => 'add', '?' => ['student_id' => $schStudent->id]], ['class' => 'btn btn-success fw-bold', 'escape' => false]) ?>
            </div>
        </div>

        <!-- Tab Nav -->
        <nav class="d-flex gap-2" id="student-tabs" style="margin:0 -2rem;">
            <a href="javascript:void(0)" class="profile-tab active" data-target="tab-overview">Overview</a>
            <a href="javascript:void(0)" class="profile-tab" data-target="tab-academics">Academics</a>
            <a href="javascript:void(0)" class="profile-tab" data-target="tab-finance">Financials</a>
        </nav>
    </div>
</div>

<!-- ── TAB CONTENT CONTAINERS ─────────────────────────────────────────────── -->

<!-- 1. OVERVIEW TAB -->
<div id="tab-overview" class="student-tab-content active-tab">
    <div class="row g-4 mb-4">
        <!-- Personal Details -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-user-circle me-2 text-primary"></i>Personal Details</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <table class="table table-sm table-borderless mb-0 no-dt" style="font-size:1rem;">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-bold ps-0" style="width:40%;">First Name</td>
                                <td class="fw-medium text-dark"><?= h($schStudent->first_name ?: '—') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold ps-0">Last Name</td>
                                <td class="fw-medium text-dark"><?= h($schStudent->last_name ?: '—') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold ps-0">Gender</td>
                                <td class="fw-medium text-dark"><?= h($schStudent->gender ?: '—') ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold ps-0">Date of Birth</td>
                                <td class="fw-medium text-dark">
                                    <?= $schStudent->date_of_birth ? $schStudent->date_of_birth->format('d M Y') : '—' ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold ps-0">Enrolled</td>
                                <td class="text-muted"><?= $schStudent->created->format('d M Y') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Guardian Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-user-friends me-2 text-info"></i>Guardian / Parent</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <?php
                        $guardianName  = $schStudent->hasValue('contact') ? $schStudent->contact->name  : ($schStudent->guardian_name  ?: null);
                        $guardianPhone = $schStudent->hasValue('contact') ? $schStudent->contact->mobile : ($schStudent->guardian_phone ?: null);
                    ?>
                    <?php if ($guardianName): ?>
                    <div class="d-flex align-items-center gap-3 mt-2">
                        <div style="width:50px;height:50px;background:#e0f2fe;color:#0284c7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.1rem;flex-shrink:0;">
                            <?= strtoupper(substr($guardianName, 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-5"><?= h($guardianName) ?></div>
                            <?php if ($guardianPhone): ?>
                            <div class="text-dark fw-bold mt-1"><i class="fas fa-phone me-2"></i><?= h($guardianPhone) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <p class="text-muted fst-italic mb-0 mt-2">No guardian contact linked.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary Card (Full width overview) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-wallet me-2 text-success"></i>Fee Summary</h6>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-light rounded-3 h-100 border">
                        <div class="text-muted small text-uppercase fw-bold mb-2">Total Invoiced</div>
                        <div class="fs-3 fw-bold text-dark"><?= $currency ?> <?= number_format($totalBilled, 2) ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-light rounded-3 h-100 border">
                        <div class="text-muted small text-uppercase fw-bold mb-2">Total Received</div>
                        <div class="fs-3 fw-bold text-success"><?= $currency ?> <?= number_format($totalReceipted, 2) ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 <?= $outstanding > 0 ? 'bg-soft-danger border-danger' : 'bg-soft-success border-success' ?> rounded-3 h-100 border" style="border-opacity: 0.3;">
                        <div class="<?= $outstanding > 0 ? 'text-danger' : 'text-success' ?> small text-uppercase fw-bold mb-2">Outstanding Balance</div>
                        <div class="fs-3 fw-bold <?= $outstanding > 0 ? 'text-danger' : 'text-success' ?>">
                            <?= $currency ?> <?= number_format(abs($outstanding), 2) ?>
                            <?php if ($outstanding < 0): ?><span class="fs-5 text-muted">(Credit)</span><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. ACADEMICS TAB -->
<div id="tab-academics" class="student-tab-content" style="display:none;">
    
    <!-- ── Attendance Summary ─────────────────────────────────── -->
    <?php
        $attendanceCount  = count($schStudent->sch_attendance ?? []);
        $presentCount     = count(array_filter($schStudent->sch_attendance ?? [], fn($a) => strtolower($a->status ?? '') === 'present'));
        $absentCount      = count(array_filter($schStudent->sch_attendance ?? [], fn($a) => strtolower($a->status ?? '') === 'absent'));
        $attendancePct    = $attendanceCount > 0 ? round(($presentCount / $attendanceCount) * 100) : null;
    ?>
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-check me-2 text-success"></i>Attendance Summary</h6>
            <?php if ($attendancePct !== null): ?>
            <span class="fw-bold fs-5 <?= $attendancePct >= 75 ? 'text-success' : 'text-danger' ?>"><?= $attendancePct ?>% Rate</span>
            <?php endif; ?>
        </div>
        <div class="card-body px-4 pb-4 pt-0">
            <?php if ($attendanceCount > 0): ?>
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between p-3 rounded-3 border mb-4 bg-light shadow-sm">
                <div class="text-center w-100 py-2 border-end">
                    <div class="fs-3 fw-bold text-success"><?= $presentCount ?></div>
                    <div class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">Present</div>
                </div>
                <div class="text-center w-100 py-2 border-end">
                    <div class="fs-3 fw-bold text-danger"><?= $absentCount ?></div>
                    <div class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">Absent</div>
                </div>
                <div class="text-center w-100 py-2">
                    <div class="fs-3 fw-bold text-warning"><?= $attendanceCount - $presentCount - $absentCount ?></div>
                    <div class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">Excused</div>
                </div>
            </div>
            <!-- Attendance bar -->
            <div class="progress shadow-sm" style="height:12px;border-radius:20px;">
                <div class="progress-bar <?= $attendancePct >= 75 ? 'bg-success' : ($attendancePct >= 50 ? 'bg-warning' : 'bg-danger') ?>" style="width:<?= $attendancePct ?>%;"></div>
            </div>
            <?php else: ?>
            <div class="text-center py-4 text-muted">
                <i class="fas fa-calendar-times fs-2 opacity-25 d-block mb-2"></i>
                <p class="mb-0 fs-6">No attendance records found.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── Academic Results ───────────────────────────────────── -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-graduation-cap me-2 text-primary"></i>Examination Results</h6>
            <span class="badge bg-primary rounded-pill fs-6"><?= count($schStudent->sch_results ?? []) ?> records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt" style="font-size:1rem;">
                    <thead class="bg-light text-muted text-uppercase" style="font-size:.8rem;">
                        <tr>
                            <th class="ps-4 py-3">Subject</th>
                            <th class="py-3">Exam</th>
                            <th class="py-3" style="width: 200px;">Marks</th>
                            <th class="py-3">Grade</th>
                            <th class="pe-4 py-3 text-end">Date Recorded</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schStudent->sch_results)): ?>
                            <?php foreach ($schStudent->sch_results as $result): ?>
                            <?php
                                $marks = (float)($result->marks ?? 0);
                                $barColor = $marks >= 70 ? '#10b981' : ($marks >= 50 ? '#f59e0b' : '#ef4444');
                            ?>
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark"><?= h($result->sch_subject->name ?? '—') ?></td>
                                <td class="py-3 text-muted"><?= h($result->sch_exam->name ?? '—') ?></td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress flex-grow-1" style="height:8px;">
                                            <div class="progress-bar" style="width:<?= min($marks,100) ?>%;background:<?= $barColor ?>;"></div>
                                        </div>
                                        <span class="fw-bold" style="color:<?= $barColor ?>"><?= $marks ?>%</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <?php if ($result->grade): ?>
                                    <span class="badge rounded-pill px-3 py-2" style="background:#f0fdf4;color:#166534;font-size:.9rem;"><?= h($result->grade) ?></span>
                                    <?php else: ?>
                                    <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 py-3 text-end text-muted"><?= $result->created->format('d M Y') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-clipboard fs-1 opacity-25 d-block mb-3"></i>
                                    <p class="mb-0 fs-5">No examination results recorded yet.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 3. FINANCIALS TAB -->
<div id="tab-finance" class="student-tab-content" style="display:none;">
    
    <!-- ── Financials ─────────────────────────────────────────── -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-danger"></i>Invoices &amp; Receipts</h6>
        </div>
        <div class="card-body p-0">

            <!-- Invoices -->
            <?php if (!empty($schStudent->invoices)): ?>
            <div class="px-4 py-3 bg-light border-bottom border-top mt-2">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-file-invoice me-2 text-primary"></i>Invoice History</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt" style="font-size:1rem;">
                    <thead class="text-muted text-uppercase" style="font-size:.8rem;">
                        <tr>
                            <th class="ps-4 py-3">Reference</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Currency</th>
                            <th class="py-3 text-end">Amount</th>
                            <th class="text-center pe-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schStudent->invoices as $invoice): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold">
                                <?= $this->Html->link(h($invoice->reference ?? "INV-{$invoice->id}"), ['controller' => 'Invoices', 'action' => 'view', $invoice->id], ['class' => 'text-dark text-decoration-none']) ?>
                            </td>
                            <td class="py-3 text-muted"><?= $invoice->date ? $invoice->date->format('d M Y') : '—' ?></td>
                            <td class="py-3 text-muted"><?= h($invoice->description ?? '—') ?></td>
                            <td class="py-3"><?= h($invoice->currency) ?></td>
                            <td class="py-3 text-end fw-bold"><?= number_format((float)$invoice->total, 2) ?></td>
                            <td class="text-center pe-4 py-3">
                                <?php $sc = match(strtolower($invoice->status ?? '')) {
                                    'paid' => 'bg-success', 'overdue' => 'bg-danger',
                                    'sent' => 'bg-info', 'approved' => 'bg-primary', default => 'bg-secondary'
                                }; ?>
                                <span class="badge <?= $sc ?> rounded-pill px-3 py-2"><?= h($invoice->status) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <!-- Receipts -->
            <?php if (!empty($schStudent->receipts)): ?>
            <div class="px-4 py-3 bg-light border-bottom border-top mt-4">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-receipt me-2 text-success"></i>Receipt History</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt" style="font-size:1rem;">
                    <thead class="text-muted text-uppercase" style="font-size:.8rem;">
                        <tr>
                            <th class="ps-4 py-3">Reference</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Mode</th>
                            <th class="py-3">Currency</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schStudent->receipts as $receipt): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold">
                                <?= $this->Html->link(h($receipt->reference ?? $receipt->manual_reference ?? "RCT-{$receipt->id}"), ['controller' => 'Receipts', 'action' => 'view', $receipt->id], ['class' => 'text-success text-decoration-none']) ?>
                            </td>
                            <td class="py-3 text-muted"><?= $receipt->date ? (is_string($receipt->date) ? $receipt->date : $receipt->date->format('d M Y')) : '—' ?></td>
                            <td class="py-3 text-muted"><?= h($receipt->description ?? '—') ?></td>
                            <td class="py-3"><?= h($receipt->currency) ?></td>
                            <td class="py-3">
                                <?php $rs = match(strtolower($receipt->status ?? '')) {
                                    'approved' => 'bg-success', 'rejected' => 'bg-danger',
                                    'pending approval' => 'bg-warning text-dark', default => 'bg-secondary'
                                }; ?>
                                <span class="badge <?= $rs ?> rounded-pill px-3 py-2"><?= h($receipt->status) ?></span>
                            </td>
                            <td class="py-3 text-end fw-bold text-success pe-4"><?= number_format((float)$receipt->amount, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <?php if (empty($schStudent->invoices) && empty($schStudent->receipts)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fs-1 opacity-25 d-block mb-3"></i>
                <p class="mb-1 fs-5">No financial records yet.</p>
                <small>Use the buttons in the header to create an invoice or record a payment.</small>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
.profile-tab {
    display: inline-block;
    padding: .8rem 1.6rem;
    color: rgba(255,255,255,.7);
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    border-bottom: 4px solid transparent;
    transition: all .2s;
    cursor: pointer;
}
.profile-tab.active, .profile-tab:hover {
    color: #fff;
    border-bottom-color: #fff;
}
.progress { background: #e2e8f0; }
.card { border-radius: 12px !important; }
.bg-soft-success { background: #f0fdf4; color: #166534; }
.bg-soft-danger { background: #fef2f2; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll('.profile-tab');
    const contents = document.querySelectorAll('.student-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active to clicked tab
            this.classList.add('active');
            
            // Hide all content panes
            contents.forEach(c => c.style.display = 'none');
            
            // Show targeted pane
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).style.display = 'block';
        });
    });
});
</script>
