<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchStudent> $schStudents
 */
?>
<div class="schStudents index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Student Directory') ?></h2>
            <p class="text-muted small">Manage admissions, profile records, and academic status.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('Admit Student'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('admission_no', 'Admission #') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Student Info') ?></th>
                            <th><?= $this->Paginator->sort('class_id', 'Class / Grade') ?></th>
                            <th><?= __('Guardian Details') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schStudents as $student): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-primary">#<?= h($student->admission_no) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <?= strtoupper(substr($student->user->name ?? 'S', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= $student->hasValue('user') ? h($student->user->name) : 'Unlinked User' ?></div>
                                        <div class="text-muted small">DOB: <?= $student->date_of_birth ? $student->date_of_birth->format('d M Y') : 'N/A' ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= $student->hasValue('sch_class') ? h($student->sch_class->name) : 'Pending' ?>
                                </span>
                            </td>
                            <td>
                                <div class="small">
                                    <div class="fw-medium text-dark"><?= $student->hasValue('contact') ? h($student->contact->name) : h($student->guardian_name ?: 'Unknown') ?></div>
                                    <div class="text-muted"><?= $student->hasValue('contact') ? h($student->contact->mobile) : h($student->guardian_phone ?: 'No Phone') ?></div>
                                </div>
                            </td>
                            <td>
                                <span class="dot-status bg-success"></span> Active
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $student->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Profile']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $student->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Profile']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $student->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Withdraw Student']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schStudents->count() === 0): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No students enrolled.</td></tr>
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
