<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchStudent $schStudent
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $schClasses
 * @var array $contacts
 */
?>
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1"><i class="fas fa-user-graduate me-2 text-primary"></i>Admit New Student</h2>
                <p class="text-muted small mb-0">Complete all sections to register a new student.</p>
            </div>
            <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Back to List', ['action' => 'index'], ['class' => 'btn btn-outline-secondary btn-sm', 'escape' => false]) ?>
        </div>

        <?= $this->Form->create($schStudent, ['id' => 'admit-student-form']) ?>

        <!-- ── SECTION 1: Student Identity ────────────────────────────── -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg,#4f46e5,#3b82f6);">
                <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user me-2"></i>Student Identity</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <?= $this->Form->control('first_name', [
                            'class'       => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. John',
                            'label'       => ['text' => 'First Name *', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('last_name', [
                            'class'       => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. Doe',
                            'label'       => ['text' => 'Last Name *', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('gender', [
                            'type'    => 'select',
                            'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
                            'empty'   => '— Gender —',
                            'class'   => 'form-select form-select-lg bg-light border-0',
                            'label'   => ['text' => 'Gender', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('date_of_birth', [
                            'type'  => 'date',
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'label' => ['text' => 'Date of Birth', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('user_id', [
                            'options' => $users,
                            'empty'   => '— Link System Account (Optional) —',
                            'class'   => 'form-select form-select-lg bg-light border-0',
                            'label'   => ['text' => 'System User Account', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SECTION 2: Academic Details ────────────────────────────── -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg,#059669,#10b981);">
                <h5 class="mb-0 text-white fw-bold"><i class="fas fa-graduation-cap me-2"></i>Academic Details</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Admission Number</label>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge fs-6 px-4 py-2 fw-bold" style="background:#dcfce7; color:#166534; border:2px solid #86efac; border-radius:10px; letter-spacing:1px;">
                                <i class="fas fa-id-badge me-2"></i><?= h($nextAdmNo) ?>
                            </span>
                            <span class="text-muted small">Auto-generated &mdash; cannot be changed</span>
                        </div>
                        <?= $this->Form->hidden('admission_no', ['value' => $nextAdmNo]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('class_id', [
                            'options' => $schClasses,
                            'empty'   => '— Select Class / Grade —',
                            'class'   => 'form-select form-select-lg bg-light border-0',
                            'label'   => ['text' => 'Class / Grade *', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SECTION 3: Guardian / Contact ──────────────────────────── -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 py-3 px-4" style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user-friends me-2"></i>Guardian / Parent Contact</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted text-uppercase mb-2">Link Existing Contact</label>
                    <div class="input-group">
                        <?= $this->Form->select('contact_id', $contacts ?? [], [
                            'id'    => 'contact-id-select',
                            'empty' => '— Search for an existing contact —',
                            'class' => 'form-select form-select-lg bg-light border-0',
                        ]) ?>
                        <a href="/contacts/add" class="btn btn-outline-primary global-quick-add-btn"
                           data-url="/contacts/add"
                           data-target-dropdown="contact-id-select"
                           title="Quick-add new contact">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <small class="text-muted mt-1 d-block">Search for a parent/guardian already in Contacts.</small>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-muted small fw-bold text-uppercase">Or Quick Add New</span>
                    <hr class="flex-grow-1">
                </div>

                <div class="p-4 rounded-3" style="background:#f8faff; border: 1px dashed #bfdbfe;">
                    <p class="small text-primary fw-bold mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Fill in these fields to auto-create a new guardian contact on save. Leave blank if you linked one above.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('guardian_name', [
                                'class'       => 'form-control bg-white border-0',
                                'placeholder' => 'Full Name',
                                'label'       => ['text' => 'Guardian Name', 'class' => 'form-label small fw-bold text-muted mb-1'],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('guardian_phone', [
                                'class'       => 'form-control bg-white border-0',
                                'placeholder' => 'e.g. +263 77 123 4567',
                                'label'       => ['text' => 'Guardian Phone', 'class' => 'form-label small fw-bold text-muted mb-1'],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-3 justify-content-end mb-5">
            <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-light btn-lg px-5 text-muted']) ?>
            <?= $this->Form->button('<i class="fas fa-user-plus me-2"></i>Admit Student', ['class' => 'btn btn-primary btn-lg px-5 shadow-sm', 'escape' => false]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    background-color: #fff !important;
    box-shadow: 0 0 0 0.25rem rgba(59,130,246,0.12);
    border: 1px solid #3b82f6 !important;
}
.card { border-radius: 14px !important; }
.card-header { border-radius: 14px 14px 0 0 !important; }
</style>
