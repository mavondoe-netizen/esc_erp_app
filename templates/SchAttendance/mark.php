<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchStudent> $students
 * @var array $schClasses
 * @var int|null $classId
 * @var string $date
 */
?>
<div class="schAttendance mark content">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success text-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold"><?= __('Daily Roll Call') ?></h3>
                <p class="mb-0 opacity-75">Mark student presence for the selected class and date.</p>
            </div>
            <div class="text-end">
                <h4 class="mb-0 fw-bold"><?= date('l, d M Y', strtotime($date)) ?></h4>
            </div>
        </div>
        <div class="card-body p-4">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-end mb-4']) ?>
                <div class="column column-40">
                    <label class="form-label fw-bold small text-muted text-uppercase"><?= __('Select Class') ?></label>
                    <?= $this->Form->select('class_id', $schClasses, ['value' => $classId, 'empty' => 'Choose a Class...', 'class' => 'form-select bg-light border-0']) ?>
                </div>
                <div class="column column-30">
                    <label class="form-label fw-bold small text-muted text-uppercase"><?= __('Date') ?></label>
                    <?= $this->Form->date('date', ['value' => $date, 'class' => 'form-control bg-light border-0']) ?>
                </div>
                <div class="column column-30">
                    <?= $this->Form->button(__('Load Roll Call'), ['class' => 'btn btn-success w-100 shadow-sm border-0']) ?>
                </div>
            <?= $this->Form->end() ?>

            <?php if (!empty($students)): ?>
                <?= $this->Form->create(null, ['url' => ['action' => 'mark']]) ?>
                <div class="table-responsive mt-5">
                    <table class="table table-hover align-middle no-dt">
                        <thead class="bg-light small text-muted text-uppercase">
                            <tr>
                                <th class="ps-4">Admission #</th>
                                <th>Student Name</th>
                                <th class="text-center">Attendance Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?= h($student->admission_no) ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= h($student->user->name ?? 'N/A') ?></div>
                                    <?= $this->Form->hidden("attendance.$index.student_id", ['value' => $student->id]) ?>
                                    <?= $this->Form->hidden("attendance.$index.date", ['value' => $date]) ?>
                                </td>
                                <td class="text-center">
                                    <div class="attendance-toggle d-flex justify-content-center gap-2">
                                        <label class="btn btn-outline-success btn-sm px-3">
                                            <input type="radio" name="attendance[<?= $index ?>][status]" value="Present" checked class="d-none"> Present
                                        </label>
                                        <label class="btn btn-outline-danger btn-sm px-3">
                                            <input type="radio" name="attendance[<?= $index ?>][status]" value="Absent" class="d-none"> Absent
                                        </label>
                                        <label class="btn btn-outline-warning btn-sm px-3">
                                            <input type="radio" name="attendance[<?= $index ?>][status]" value="Excused" class="d-none"> Excused
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <?= $this->Form->button(__('Save Daily Attendance'), ['class' => 'btn btn-success btn-lg shadow-sm px-5']) ?>
                </div>
                <?= $this->Form->end() ?>
            <?php elseif ($classId): ?>
                <div class="text-center py-5">
                    <div class="text-muted">No students found in this class.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.attendance-toggle input:checked + label { background: currentColor; color: white !important; }
.attendance-toggle label:has(input:checked) { background: #198754; color: white; }
.attendance-toggle label:has(input[value="Absent"]:checked) { background: #dc3545; color: white; }
.attendance-toggle label:has(input[value="Excused"]:checked) { background: #ffc107; color: white; }

.attendance-toggle label { transition: all 0.2s ease; cursor: pointer; border-radius: 20px; font-weight: 700; }
</style>

<script>
document.querySelectorAll('.attendance-toggle label').forEach(label => {
    label.addEventListener('click', function() {
        const parent = this.closest('.attendance-toggle');
        parent.querySelectorAll('label').forEach(l => l.style.background = '');
        const input = this.querySelector('input');
        if (input.value === 'Present') this.style.background = '#198754';
        if (input.value === 'Absent') this.style.background = '#dc3545';
        if (input.value === 'Excused') this.style.background = '#ffc107';
        this.style.color = 'white';
    });
});
</script>
