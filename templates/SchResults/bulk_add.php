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
                                    <div class="fw-medium text-dark"><?= h($student->user->name ?? 'N/A') ?></div>
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
