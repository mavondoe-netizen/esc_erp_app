<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchClass $schClass
 */
?>
<div class="row">
    <div class="column column-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold text-dark mb-1"><?= h($schClass->name) ?></h1>
                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 me-2">Section: <?= h($schClass->section ?: 'General') ?></span>
                <?php if ($schClass->academic_period): ?>
                <span class="badge bg-info rounded-pill px-3 py-2 fs-6">Period: <?= h($schClass->academic_period) ?></span>
                <?php endif; ?>
            </div>
            <div class="btn-group shadow-sm">
                <?= $this->Html->link(__('Edit Class'), ['action' => 'edit', $schClass->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $schClass->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-outline-danger']) ?>
                <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'btn btn-light']) ?>
            </div>
        </div>

        <div class="row g-4">
            <!-- Subjects Column -->
            <div class="column column-50">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-book me-2"></i><?= __('Assigned Subjects') ?></h5>
                        <?= $this->Html->link(__('Add Subject'), ['controller' => 'SchSubjects', 'action' => 'add', '?' => ['class_id' => $schClass->id]], ['class' => 'btn btn-sm btn-soft-primary']) ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="small text-muted text-uppercase">
                                    <tr>
                                        <th class="ps-4"><?= __('Subject Name') ?></th>
                                        <th class="text-end pe-4"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($schClass->sch_subjects)): ?>
                                        <?php foreach ($schClass->sch_subjects as $subject): ?>
                                        <tr>
                                            <td class="ps-4 fw-medium"><?= h($subject->name) ?></td>
                                            <td class="text-end pe-4">
                                                <?= $this->Html->link(__('View'), ['controller' => 'SchSubjects', 'action' => 'view', $subject->id], ['class' => 'btn btn-sm btn-light']) ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="2" class="text-center py-4 text-muted small italic">No subjects assigned yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Column -->
            <div class="column column-50">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-people me-2"></i><?= __('Enrolled Students') ?></h5>
                        <?= $this->Html->link(__('Admit Student'), ['controller' => 'SchStudents', 'action' => 'add', '?' => ['class_id' => $schClass->id]], ['class' => 'btn btn-sm btn-soft-success']) ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="small text-muted text-uppercase">
                                    <tr>
                                        <th class="ps-4"><?= __('Admission No.') ?></th>
                                        <th><?= __('Student Name') ?></th>
                                        <th class="text-end pe-4"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($schClass->sch_students)): ?>
                                        <?php foreach ($schClass->sch_students as $student): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= h($student->admission_no) ?></td>
                                            <td class="text-muted small">Profile link</td>
                                            <td class="text-end pe-4">
                                                <?= $this->Html->link(__('Profile'), ['controller' => 'SchStudents', 'action' => 'view', $student->id], ['class' => 'btn btn-sm btn-light']) ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center py-4 text-muted small italic">No students enrolled yet.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-soft-primary { background: #eef2ff; color: #4f46e5; border: none; }
.btn-soft-primary:hover { background: #4f46e5; color: white; }
.btn-soft-success { background: #f0fdf4; color: #166534; border: none; }
.btn-soft-success:hover { background: #166534; color: white; }
</style>
