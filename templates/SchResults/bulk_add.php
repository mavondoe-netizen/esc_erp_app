<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchStudent> $students
 * @var array $schClasses
 * @var array $schSubjects
 * @var array $schExams
 */
?>
<div class="schResults bulk-add content">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-4 px-4 border-0">
            <h3 class="mb-1 fw-bold"><?= __('Bulk Marks Entry') ?></h3>
            <p class="mb-0 opacity-75">Select a class, subject, and exam to record marks for all students.</p>
        </div>
        <div class="card-body p-4">

            <?php if (empty($schExams)): ?>
            <div class="alert border-0 d-flex align-items-start gap-3 mb-4" style="background:#fff7ed; border-left: 4px solid #f97316 !important; border-radius: 10px;">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-4 mt-1"></i>
                <div>
                    <div class="fw-bold text-dark mb-1">No Exams Found</div>
                    <p class="mb-2 text-muted small">
                        The <strong>Exam</strong> dropdown is empty because no exam sessions have been created yet.
                        You must first define your exams (e.g. <em>Mid-Term 1, Term 2 Final, Mock Exam</em>) before you can enter marks.
                    </p>
                    <?= $this->Html->link(
                        '<i class="bi bi-plus-circle me-1"></i> Create an Exam Now',
                        ['controller' => 'SchExams', 'action' => 'add'],
                        ['class' => 'btn btn-sm btn-warning fw-bold', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="bi bi-list me-1"></i> View All Exams',
                        ['controller' => 'SchExams', 'action' => 'index'],
                        ['class' => 'btn btn-sm btn-outline-secondary ms-2', 'escape' => false]
                    ) ?>
                </div>
            </div>
            <?php endif; ?>

            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-end mb-4']) ?>
                <div class="column column-25">
                    <label class="form-label fw-bold small text-muted text-uppercase"><?= __('Class') ?></label>
                    <?= $this->Form->select('class_id', $schClasses, ['value' => $classId, 'empty' => 'Select Class', 'class' => 'form-select bg-light border-0']) ?>
                </div>
                <div class="column column-25">
                    <label class="form-label fw-bold small text-muted text-uppercase"><?= __('Subject') ?></label>
                    <?= $this->Form->select('subject_id', $schSubjects, ['value' => $subjectId, 'empty' => 'Select Subject', 'class' => 'form-select bg-light border-0']) ?>
                </div>
                <div class="column column-25">
                    <label class="form-label fw-bold small text-muted text-uppercase"><?= __('Exam') ?></label>
                    <?= $this->Form->select('exam_id', $schExams, ['value' => $examId, 'empty' => 'Select Exam', 'class' => 'form-select bg-light border-0']) ?>
                </div>
                <div class="column column-25">
                    <?= $this->Form->button(__('Load Students'), ['class' => 'btn btn-primary w-100 shadow-sm border-0']) ?>
                </div>
            <?= $this->Form->end() ?>

            <?php if (!empty($students)): ?>
                <?= $this->Form->create(null, ['url' => ['action' => 'bulkAdd']]) ?>
                <div class="table-responsive mt-5">
                    <table class="table table-hover align-middle no-dt">
                        <thead class="bg-light small text-muted text-uppercase">
                            <tr>
                                <th class="ps-4" style="width: 15%;">Admission #</th>
                                <th>Student Name</th>
                                <th style="width: 25%;">Marks (%)</th>
                                <th style="width: 30%;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?= h($student->admission_no) ?></td>
                                <td>
                                    <?php
                                        $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
                                        if (!$fullName) $fullName = $student->user->name ?? null;
                                    ?>
                                    <div class="fw-bold text-dark">
                                        <?= $fullName ? h($fullName) : '<span class="text-muted fst-italic">No Name Set</span>' ?>
                                    </div>
                                    <div class="text-muted small"><?= h($student->admission_no) ?></div>
                                    <?= $this->Form->hidden("results.$index.student_id", ['value' => $student->id]) ?>
                                    <?= $this->Form->hidden("results.$index.subject_id", ['value' => $subjectId]) ?>
                                    <?= $this->Form->hidden("results.$index.exam_id", ['value' => $examId]) ?>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <?= $this->Form->number("results.$index.marks", [
                                            'class' => 'form-control border-0 bg-light', 
                                            'min' => 0, 
                                            'max' => 100, 
                                            'placeholder' => '0-100'
                                        ]) ?>
                                        <span class="input-group-text border-0 bg-light">%</span>
                                    </div>
                                </td>
                                <td>
                                    <?= $this->Form->text("results.$index.remarks", ['class' => 'form-control border-0 bg-light', 'placeholder' => 'Feedback...']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <?= $this->Form->button(__('Save All Results'), ['class' => 'btn btn-success btn-lg shadow-sm px-5']) ?>
                </div>
                <?= $this->Form->end() ?>
            <?php elseif ($classId): ?>
                <div class="text-center py-5">
                    <div class="text-muted">No students found in the selected class.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
