<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchTeacher> $schTeachers
 */
?>
<div class="schTeachers index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Teachers Directory') ?></h2>
            <p class="text-muted small">Manage teaching staff profiles and assignments.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('Add Teacher'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('employee_no', 'Employee #') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Teacher Info') ?></th>
                            <th><?= $this->Paginator->sort('specialty', 'Specialty') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schTeachers as $teacher): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-primary">#<?= h($teacher->employee_no) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <?= strtoupper(substr($teacher->user->name ?? $teacher->employee->first_name ?? 'T', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">
                                            <?php if ($teacher->hasValue('employee')): ?>
                                                <?= h($teacher->employee->first_name . ' ' . $teacher->employee->last_name) ?>
                                            <?php elseif ($teacher->hasValue('user')): ?>
                                                <?= h($teacher->user->name) ?>
                                            <?php else: ?>
                                                Unlinked
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?php if ($teacher->hasValue('employee')): ?>
                                                <span class="badge bg-soft-success text-success me-1"><?= h($teacher->employee->employee_code) ?></span>
                                                <?= h($teacher->employee->designation ?: '') ?>
                                            <?php elseif ($teacher->hasValue('user')): ?>
                                                <?= h($teacher->user->email) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= h($teacher->specialty ?: 'General') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($teacher->hasValue('employee')): ?>
                                    <span class="dot-status bg-success"></span>
                                    <?= h($teacher->employee->termination_date ? 'Terminated' : 'Active') ?>
                                <?php else: ?>
                                    <span class="dot-status bg-warning"></span> No HR Record
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $teacher->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Profile']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $teacher->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Profile']) ?>
                                    <?php if ($teacher->hasValue('employee')): ?>
                                        <?= $this->Html->link(__('<i class="fas fa-id-badge"></i>'), ['controller' => 'Employees', 'action' => 'view', $teacher->employee_id], ['class' => 'btn btn-sm btn-light text-info', 'escape' => false, 'title' => 'View HR Record']) ?>
                                    <?php endif; ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $teacher->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete Profile']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schTeachers->count() === 0): ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">No teachers found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="paginator mt-4">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('«') ?>
            <?= $this->Paginator->prev('‹') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('›') ?>
            <?= $this->Paginator->last('»') ?>
        </ul>
        <p class="text-center text-muted small"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background: #eef2ff;
    color: #4f46e5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.85rem;
}
.bg-soft-info { background: #ecfeff; color: #0891b2 !important; }
.dot-status { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 5px; }
.bg-success { background: #10b981 !important; }
</style>
