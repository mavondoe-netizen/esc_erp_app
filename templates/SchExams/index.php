<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchExam> $schExams
 */
?>
<div class="schExams index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Examinations') ?></h2>
            <p class="text-muted small">Manage school terms, exams, and assessment schedules.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('New Exam'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Exam Name') ?></th>
                            <th>Subject</th>
                            <th><?= $this->Paginator->sort('term', 'Term') ?></th>
                            <th><?= $this->Paginator->sort('year', 'Year') ?></th>
                            <th><?= $this->Paginator->sort('date', 'Date') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schExams as $schExam): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $this->Number->format($schExam->id) ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= h($schExam->name) ?></div>
                            </td>
                            <td>
                                <?php if ($schExam->hasValue('sch_subject')): ?>
                                    <span class="badge bg-soft-purple text-purple rounded-pill px-3">
                                        <i class="fas fa-book me-1"></i><?= h($schExam->sch_subject->name) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= h($schExam->term) ?>
                                </span>
                            </td>
                            <td><?= h($schExam->year) ?></td>
                            <td class="text-muted small"><?= h($schExam->date ? $schExam->date->format('d M Y') : '') ?></td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $schExam->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Results']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $schExam->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Exam']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $schExam->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete Exam']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schExams->count() === 0): ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted">No exams found. <?= $this->Html->link('Create one now →', ['action' => 'add'], ['class' => 'text-primary fw-bold ms-1']) ?></td></tr>
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
.bg-soft-info   { background-color: rgba(13, 202, 240, 0.12) !important; }
.text-info      { color: #0dcaf0 !important; }
.bg-soft-purple { background-color: #ede9fe !important; }
.text-purple    { color: #7c3aed !important; }
</style>
