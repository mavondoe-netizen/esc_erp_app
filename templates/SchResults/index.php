<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchResult> $schResults
 */
?>
<div class="schResults index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Exam Results') ?></h2>
            <p class="text-muted small">Manage student marks and grading records.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('Bulk Entry'), ['action' => 'bulkAdd'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('student_id', 'Student') ?></th>
                            <th><?= $this->Paginator->sort('subject_id', 'Subject') ?></th>
                            <th><?= $this->Paginator->sort('exam_id', 'Exam') ?></th>
                            <th><?= $this->Paginator->sort('marks', 'Marks') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schResults as $result): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $this->Number->format($result->id) ?></td>
                            <td>
                                <div class="fw-bold text-dark">
                                    <?= $result->hasValue('sch_student') ? h($result->sch_student->admission_no) : 'N/A' ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= $result->hasValue('sch_subject') ? h($result->sch_subject->name) : 'N/A' ?>
                                </span>
                            </td>
                            <td>
                                <?= $result->hasValue('sch_exam') ? h($result->sch_exam->name) : 'N/A' ?>
                            </td>
                            <td>
                                <strong class="text-primary"><?= $this->Number->format($result->marks) ?>%</strong>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $result->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Result']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $result->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete Result']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schResults->count() === 0): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No results recorded.</td></tr>
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
.bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
.text-info { color: #0dcaf0 !important; }
</style>
