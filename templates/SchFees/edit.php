<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchFee $schFee
 * @var array $schStudents
 */
?>
<div class="row justify-content-center">
    <div class="column column-50">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Edit Fee Record') ?></h3>
                <p class="mb-0 opacity-75 small">Update fee amounts or payment status.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schFee) ?>
                <fieldset class="border-0 p-0 m-0">
                    <div class="mb-4">
                        <?= $this->Form->control('student_id', [
                            'options' => $schStudents,
                            'empty' => 'Select Student',
                            'class' => 'form-select form-select-lg bg-light border-0',
                            'label' => ['text' => 'Student', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <?= $this->Form->control('amount', [
                                'class' => 'form-control form-control-lg bg-light border-0 text-danger fw-bold',
                                'placeholder' => '0.00',
                                'label' => ['text' => 'Amount Due', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                        <div class="col-6">
                            <?= $this->Form->control('paid', [
                                'class' => 'form-control form-control-lg bg-light border-0 text-success fw-bold',
                                'placeholder' => '0.00',
                                'label' => ['text' => 'Amount Paid', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                            ]) ?>
                        </div>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('due_date', [
                            'type' => 'date',
                            'empty' => true,
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'label' => ['text' => 'Due Date', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                </fieldset>
                <div class="d-grid gap-2 mt-5">
                    <?= $this->Form->button(__('Update Fee Record'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-light btn-lg text-muted']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%) !important; }
.form-control:focus, .form-select:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6 !important; }
</style>
