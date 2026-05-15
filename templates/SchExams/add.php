<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchExam $schExam
 * @var array $schSubjects
 */
?>
<div class="row justify-content-center">
    <div class="column column-55">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Create Examination') ?></h3>
                <p class="mb-0 opacity-75 small">Define a new assessment or exam session for a subject.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schExam) ?>
                <fieldset class="border-0 p-0 m-0">

                    <!-- Exam Name -->
                    <div class="mb-4">
                        <?= $this->Form->control('name', [
                            'class'       => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. Mid-Term 1, Final Exam, Mock Exam',
                            'label'       => ['text' => 'Examination Name *', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <?= $this->Form->control('subject_id', [
                            'options'     => $schSubjects,
                            'empty'       => '— Select Subject —',
                            'class'       => 'form-select form-select-lg bg-light border-0',
                            'label'       => ['text' => 'Subject *', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                        <small class="text-muted">Select the subject this examination belongs to.</small>
                    </div>

                    <!-- Term & Year -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <?= $this->Form->control('term', [
                                'class'       => 'form-control form-control-lg bg-light border-0',
                                'placeholder' => 'e.g. Term 1',
                                'label'       => ['text' => 'Term', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                            ]) ?>
                        </div>
                        <div class="col-6">
                            <?= $this->Form->control('year', [
                                'class'       => 'form-control form-control-lg bg-light border-0',
                                'placeholder' => 'e.g. ' . date('Y'),
                                'label'       => ['text' => 'Year', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                                'value'       => $schExam->year ?? date('Y'),
                            ]) ?>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <?= $this->Form->control('date', [
                            'type'  => 'date',
                            'empty' => true,
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'label' => ['text' => 'Exam Date', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2'],
                        ]) ?>
                    </div>

                </fieldset>
                <div class="d-grid gap-2 mt-5">
                    <?= $this->Form->button(__('Create Examination'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
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
