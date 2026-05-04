<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchTeacher $schTeacher
 */
$emp = $schTeacher->hasValue('employee') ? $schTeacher->employee : null;
$usr = $schTeacher->hasValue('user') ? $schTeacher->user : null;
$displayName = $emp ? ($emp->first_name . ' ' . $emp->last_name) : ($usr->name ?? 'Teacher Profile');
$initial     = strtoupper(substr($displayName, 0, 1));
?>
<div class="teacher-profile">

    <!-- Header Card -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="py-5 px-4 d-flex align-items-center justify-content-between text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);">
                <div class="d-flex align-items-center">
                    <div class="teacher-avatar me-4 shadow-lg"><?= $initial ?></div>
                    <div>
                        <h1 class="fw-bold mb-0"><?= h($displayName) ?></h1>
                        <p class="mb-0 opacity-75">
                            Employee # <span class="fw-bold"><?= h($schTeacher->employee_no) ?></span>
                            | Specialty: <?= h($schTeacher->specialty ?: 'General') ?>
                        </p>
                    </div>
                </div>
                <div class="text-end">
                    <?php if ($emp): ?>
                        <span class="badge bg-white text-primary rounded-pill px-4 py-2 fw-bold">
                            <?= $emp->termination_date ? 'TERMINATED' : 'ACTIVE STAFF' ?>
                        </span>
                        <div class="mt-2 text-white-50 small"><?= h($emp->designation ?: 'Teaching Staff') ?></div>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark rounded-pill px-4 py-2 fw-bold">NO HR RECORD</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Quick Actions -->
        <div class="column column-30">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge-fill me-2 text-primary"></i>Quick Actions</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <?= $this->Html->link('<i class="bi bi-pencil me-2"></i>Edit Teacher', ['action' => 'edit', $schTeacher->id], ['class' => 'btn btn-outline-primary btn-sm', 'escape' => false]) ?>
                    <?php if ($emp): ?>
                        <?= $this->Html->link('<i class="bi bi-person-badge me-2"></i>View HR Record', ['controller' => 'Employees', 'action' => 'view', $schTeacher->employee_id], ['class' => 'btn btn-outline-info btn-sm', 'escape' => false]) ?>
                        <?= $this->Html->link('<i class="bi bi-cash-stack me-2"></i>View Payslips', ['controller' => 'Payslips', 'action' => 'index', '?' => ['employee_id' => $schTeacher->employee_id]], ['class' => 'btn btn-outline-success btn-sm', 'escape' => false]) ?>
                    <?php endif; ?>
                    <?= $this->Html->link('<i class="bi bi-list me-2"></i>Back to List', ['action' => 'index'], ['class' => 'btn btn-light btn-sm', 'escape' => false]) ?>
                </div>
            </div>

            <!-- Teaching Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>Teaching Info</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Employee #</label>
                        <div class="fw-bold text-primary"><?= h($schTeacher->employee_no) ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Specialty</label>
                        <span class="badge bg-soft-info text-info px-3 py-2 rounded-pill"><?= h($schTeacher->specialty ?: 'General') ?></span>
                    </div>
                    <?php if ($usr): ?>
                    <div class="mb-0">
                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">System User</label>
                        <div class="fw-medium text-dark"><?= h($usr->name) ?></div>
                        <div class="text-muted small"><?= h($usr->email) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: HR Employee Details -->
        <div class="column column-70">
            <?php if ($emp): ?>
            <!-- HR Panel -->
            <div class="card border-0 shadow-sm mb-4 border-start border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-vcard me-2 text-primary"></i>HR Employee Details</h5>
                    <span class="badge bg-primary rounded-pill"><?= h($emp->employee_code) ?></span>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Full Name</label>
                            <div class="fw-medium text-dark"><?= h($emp->first_name . ' ' . $emp->last_name) ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Designation</label>
                            <div class="fw-medium text-dark"><?= h($emp->designation ?: '—') ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Basic Salary</label>
                            <div class="fw-bold text-success"><?= number_format((float)$emp->basic_salary, 2) ?> USD</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Start Date</label>
                            <div class="fw-medium text-dark"><?= $emp->start_date ? $emp->start_date->format('d M Y') : '—' ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Tax Number</label>
                            <div class="fw-medium text-dark"><?= h($emp->tax_number ?: '—') ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">NSSA Number</label>
                            <div class="fw-medium text-dark"><?= h($emp->nssa_number ?: '—') ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">National ID</label>
                            <div class="fw-medium text-dark"><?= h($emp->national_identity ?: '—') ?></div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Date of Birth</label>
                            <div class="fw-medium text-dark"><?= $emp->date_of_birth ? $emp->date_of_birth->format('d M Y') : '—' ?></div>
                        </div>
                    </div>

                    <!-- Bank Details -->
                    <?php if ($emp->usd_bank || $emp->zwg_bank): ?>
                    <hr class="my-4 opacity-10">
                    <h6 class="fw-bold text-muted text-uppercase small mb-3"><i class="bi bi-bank me-1"></i>Bank Details</h6>
                    <div class="row g-3">
                        <?php if ($emp->usd_bank): ?>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small text-uppercase fw-bold mb-1">USD Account</div>
                                <div class="fw-bold"><?= h($emp->usd_bank) ?> — <?= h($emp->usd_branch ?: '') ?></div>
                                <div class="text-primary small"><?= h($emp->usd_account ?: '') ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($emp->zwg_bank): ?>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3">
                                <div class="text-muted small text-uppercase fw-bold mb-1">ZWG Account</div>
                                <div class="fw-bold"><?= h($emp->zwg_bank) ?> — <?= h($emp->zwg_branch ?: '') ?></div>
                                <div class="text-primary small"><?= h($emp->zwg_account ?: '') ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <!-- No HR Record -->
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-exclamation-triangle fs-1 text-warning opacity-50 d-block mb-3"></i>
                    <h5 class="fw-bold text-dark mb-2">No HR Employee Record Linked</h5>
                    <p class="text-muted mb-4">This teacher has not been linked to an HR/Payroll employee record. Link one to enable payslip and salary management.</p>
                    <?= $this->Html->link('<i class="bi bi-link-45deg me-2"></i>Link Employee Record', ['action' => 'edit', $schTeacher->id], ['class' => 'btn btn-warning btn-sm', 'escape' => false]) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.teacher-avatar {
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
.bg-soft-info { background: #ecfeff !important; }
</style>
