<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchAttendance> $schAttendance
 */
?>
<div class="schAttendance index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Attendance Register') ?></h2>
            <p class="text-muted small">View and manage daily student attendance records.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(
                '<i class="fas fa-check-square me-2"></i>Mark Attendance',
                ['action' => 'mark'],
                ['class' => 'btn btn-success shadow-sm', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3 px-4">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-2 align-items-end']) ?>
                <div class="col-auto">
                    <label class="form-label fw-bold small text-muted text-uppercase mb-1">Date</label>
                    <?= $this->Form->date('date', [
                        'value'   => $this->request->getQuery('date', date('Y-m-d')),
                        'class'   => 'form-control form-control-sm bg-light border-0',
                    ]) ?>
                </div>
                <div class="col-auto">
                    <label class="form-label fw-bold small text-muted text-uppercase mb-1">Status</label>
                    <?= $this->Form->select('status', [
                        'Present' => 'Present',
                        'Absent'  => 'Absent',
                        'Excused' => 'Excused',
                    ], [
                        'value'   => $this->request->getQuery('status'),
                        'empty'   => 'All Statuses',
                        'class'   => 'form-select form-select-sm bg-light border-0',
                    ]) ?>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <?= $this->Html->link('Clear', ['action' => 'index'], ['class' => 'btn btn-sm btn-light ms-1']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light text-muted text-uppercase small">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('date', 'Date') ?></th>
                            <th><?= $this->Paginator->sort('student_id', 'Student') ?></th>
                            <th>Class</th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schAttendance as $record): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                <?= h($record->date instanceof \Cake\I18n\Date
                                    ? $record->date->format('d M Y')
                                    : $record->date) ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="sch-att-avatar me-3">
                                        <?= strtoupper(substr($record->sch_student->first_name ?? 'S', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">
                                            <?php if ($record->hasValue('sch_student')): ?>
                                                <?= h(trim(($record->sch_student->first_name ?? '') . ' ' . ($record->sch_student->last_name ?? ''))) ?: h($record->sch_student->admission_no) ?>
                                            <?php else: ?>
                                                Student #<?= h($record->student_id) ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($record->hasValue('sch_student')): ?>
                                        <div class="text-muted small"><?= h($record->sch_student->admission_no) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if ($record->hasValue('sch_student') && $record->sch_student->hasValue('sch_class')): ?>
                                    <span class="badge bg-soft-primary text-primary rounded-pill px-3">
                                        <?= h($record->sch_student->sch_class->name ?? '—') ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    [$badgeClass, $icon] = match($record->status) {
                                        'Present' => ['bg-success', 'bi-check-circle-fill'],
                                        'Absent'  => ['bg-danger',  'bi-x-circle-fill'],
                                        'Excused' => ['bg-warning text-dark', 'bi-exclamation-circle-fill'],
                                        default   => ['bg-secondary', 'bi-question-circle'],
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                    <i class="bi <?= $icon ?> me-1"></i><?= h($record->status) ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(
                                        '<i class="fas fa-edit"></i>',
                                        ['action' => 'mark', '?' => [
                                            'class_id' => $record->sch_student->class_id ?? '',
                                            'date'     => ($record->date instanceof \Cake\I18n\Date
                                                ? $record->date->format('Y-m-d')
                                                : $record->date),
                                        ]],
                                        ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Re-mark this date']
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-trash"></i>',
                                        ['action' => 'delete', $record->id],
                                        ['confirm' => 'Delete this attendance record?', 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete']
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (iterator_count($schAttendance) === 0): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 opacity-25 d-block mb-2"></i>
                                No attendance records found.
                                <?= $this->Html->link('Mark attendance now →', ['action' => 'mark'], ['class' => 'text-success fw-bold ms-1']) ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="paginator mt-4">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('«') ?>
            <?= $this->Paginator->prev('‹') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('›') ?>
            <?= $this->Paginator->last('»') ?>
        </ul>
        <p class="text-center text-muted small">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
</div>

<style>
.sch-att-avatar {
    width: 36px;
    height: 36px;
    background: #f0fdf4;
    color: #16a34a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.8rem;
    flex-shrink: 0;
}
.bg-soft-primary { background: #eff6ff !important; }
</style>
