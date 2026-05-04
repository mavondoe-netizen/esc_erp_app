<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchStudent $schStudent
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $schClasses
 */
?>
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Admit New Student') ?></h3>
                <p class="mb-0 opacity-75 small">Enter the student's admission details and personal information.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schStudent) ?>
                <fieldset class="border-0 p-0 m-0">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <?= $this->Form->control('admission_no', [
                                'class' => 'form-control form-control-lg bg-light border-0',
                                'placeholder' => 'e.g. ADM-2024-001',
                                'label' => ['text' => 'Admission Number', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <?= $this->Form->control('class_id', [
                                'options' => $schClasses,
                                'empty' => 'Select a Class',
                                'class' => 'form-select form-select-lg bg-light border-0',
                                'label' => ['text' => 'Class / Grade', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <?= $this->Form->control('user_id', [
                                'options' => $users,
                                'empty' => 'Select User Account',
                                'class' => 'form-select form-select-lg bg-light border-0',
                                'label' => ['text' => 'Student User Account', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <?= $this->Form->control('date_of_birth', [
                                'empty' => true,
                                'class' => 'form-control form-control-lg bg-light border-0',
                                'label' => ['text' => 'Date of Birth', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark m-0">Guardian / Contact Information</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <?= $this->Form->control('contact_id', [
                                'options' => $contacts ?? [],
                                'empty' => 'Select an existing Contact...',
                                'class' => 'form-select form-select-lg bg-light border-0 select2',
                                'label' => ['text' => 'Link Existing Contact', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded mb-4 border" id="quick-add-contact-section">
                        <p class="small text-muted fw-bold mb-3 text-uppercase"><i class="fas fa-plus-circle me-1"></i> Or Quick Add New Contact</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control('guardian_name', [
                                    'class' => 'form-control bg-white border-0',
                                    'placeholder' => 'Full Name',
                                    'label' => ['text' => 'Guardian Name', 'class' => 'form-label small text-muted mb-1']
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control('guardian_phone', [
                                    'class' => 'form-control bg-white border-0',
                                    'placeholder' => 'e.g. +1234567890',
                                    'label' => ['text' => 'Guardian Phone', 'class' => 'form-label small text-muted mb-1']
                                ]) ?>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">If you fill out these fields and leave "Link Existing Contact" empty, a new Contact will be automatically created.</small>
                    </div>
                </fieldset>
                <div class="d-grid gap-2 mt-4">
                    <?= $this->Form->button(__('Admit Student'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-light btn-lg text-muted']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%) !important; }
.form-control:focus, .form-select:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6 !important; }
</style>
