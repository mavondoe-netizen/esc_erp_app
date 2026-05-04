<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchClass> $schClasses
 */
?>
<div class="schClasses index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1"><?= __('Academic Classes') ?></h2>
            <p class="text-muted small">Manage grade levels, sections, and class structures.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('New Class'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 no-dt">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Class Name') ?></th>
                            <th><?= $this->Paginator->sort('section', 'Section/Stream') ?></th>
                            <th><?= $this->Paginator->sort('academic_period', 'Academic Period/Year') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schClasses as $schClass): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $this->Number->format($schClass->id) ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= h($schClass->name) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= h($schClass->section ?: 'General') ?>
                                </span>
                            </td>
                            <td><?= h($schClass->academic_period ?: '-') ?></td>
                            <td class="text-muted small"><?= h($schClass->created) ?></td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $schClass->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Details']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $schClass->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Class']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $schClass->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete Class']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schClasses->count() === 0): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">No classes found. Start by creating one.</div>
                            </td>
                        </tr>
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
.btn-primary { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); border: none; }
.btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
</style>
