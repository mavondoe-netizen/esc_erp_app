<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchSubject> $schSubjects
 */
?>
<div class="schSubjects index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Academic Subjects') ?></h2>
            <p class="text-muted small">Configure curriculum and assign subjects to grade levels.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('New Subject'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Subject Name') ?></th>
                            <th><?= $this->Paginator->sort('class_id', 'Assigned Class') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schSubjects as $schSubject): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $this->Number->format($schSubject->id) ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= h($schSubject->name) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-soft-primary text-primary rounded-pill px-3">
                                    <?= $schSubject->hasValue('sch_class') ? h($schSubject->sch_class->name) : 'Not Assigned' ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?= h($schSubject->created) ?></td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $schSubject->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Subject']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $schSubject->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $schSubject->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schSubjects->count() === 0): ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">No subjects configured.</td></tr>
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
.bg-soft-primary { background-color: rgba(79, 70, 229, 0.1); }
.text-primary { color: #4f46e5 !important; }
</style>
