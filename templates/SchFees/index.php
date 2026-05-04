<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SchFee> $schFees
 */
?>
<div class="schFees index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('School Fees') ?></h2>
            <p class="text-muted small">Manage student fee tracking and payments.</p>
        </div>
        <div class="d-flex gap-2">
            <?= $this->Html->link(__('<i class="fas fa-file-excel me-2"></i>Template'), ['action' => 'downloadTemplate'], ['class' => 'btn btn-outline-success btn-sm shadow-sm', 'escape' => false]) ?>
            <button class="btn btn-outline-secondary btn-sm shadow-sm" onclick="$('#global-import-input').click();"><i class="fas fa-upload me-2"></i>Bulk Import</button>
            <?= $this->Html->link(__('<i class="fas fa-download me-2"></i>Export All'), ['action' => 'export'], ['class' => 'btn btn-outline-info btn-sm shadow-sm', 'escape' => false]) ?>
            <?= $this->Html->link(__('Record Fee'), ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm']) ?>
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
                            <th><?= $this->Paginator->sort('amount', 'Amount Due') ?></th>
                            <th><?= $this->Paginator->sort('paid', 'Amount Paid') ?></th>
                            <th><?= $this->Paginator->sort('due_date', 'Due Date') ?></th>
                            <th class="text-center pe-4"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schFees as $fee): ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $this->Number->format($fee->id) ?></td>
                            <td>
                                <div class="fw-bold text-dark">
                                    <?= $fee->hasValue('sch_student') ? h($fee->sch_student->admission_no) : 'N/A' ?>
                                </div>
                            </td>
                            <td>
                                <strong class="text-danger"><?= $this->Number->format($fee->amount) ?></strong>
                            </td>
                            <td>
                                <strong class="text-success"><?= $this->Number->format($fee->paid) ?></strong>
                            </td>
                            <td class="text-muted small"><?= h($fee->due_date ? $fee->due_date->format('d M Y') : '') ?></td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['action' => 'view', $fee->id], ['class' => 'btn btn-sm btn-light text-success', 'escape' => false, 'title' => 'View Details']) ?>
                                    <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $fee->id], ['class' => 'btn btn-sm btn-light text-primary', 'escape' => false, 'title' => 'Edit Fee']) ?>
                                    <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $fee->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-sm btn-light text-danger', 'escape' => false, 'title' => 'Delete Fee']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($schFees->count() === 0): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No fee records found.</td></tr>
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

