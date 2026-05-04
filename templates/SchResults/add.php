<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchResult $schResult
 * @var array $schStudents
 * @var array $schSubjects
 * @var array $schExams
 */
?>
<div class="row justify-content-center">
    <div class="column column-50">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Record Exam Marks') ?></h3>
                <p class="mb-0 opacity-75 small">Enter a single student's subject marks.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schResult) ?>
                <fieldset class="border-0 p-0 m-0">
                    <div class="mb-4">
                        <?= $this->Form->control('student_id', [
                            'options' => $schStudents,
                            'empty' => 'Select Student',
                            'class' => 'form-select form-select-lg bg-light border-0',
                            'label' => ['text' => 'Student', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <?= $this->Form->control('exam_id', [
                                'options' => $schExams,
                                'empty' => 'Select Exam',
                                'class' => 'form-select form-select-lg bg-light border-0',
                                'label' => ['text' => 'Examination', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                        <div class="col-6">
                            <?= $this->Form->control('subject_id', [
                                'options' => $schSubjects,
                                'empty' => 'Select Subject',
                                'class' => 'form-select form-select-lg bg-light border-0',
                                'label' => ['text' => 'Subject', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">Marks (%)</label>
                        <div class="input-group input-group-lg">
                            <?= $this->Form->number('marks', [
                                'class' => 'form-control bg-light border-0 fw-bold text-primary',
                                'placeholder' => '0-100',
                                'min' => 0,
                                'max' => 100
                            ]) ?>
                            <span class="input-group-text bg-light border-0">%</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('remarks', [
                            'class' => 'form-control bg-light border-0',
                            'placeholder' => 'Teacher remarks...',
                            'rows' => 3,
                            'label' => ['text' => 'Remarks (Optional)', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                </fieldset>
                <div class="d-grid gap-2 mt-5">
                    <?= $this->Form->button(__('Save Results'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
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
