<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchSubject $schSubject
 * @var array $schClasses
 */
?>
<div class="row justify-content-center">
    <div class="column column-50">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Create New Subject') ?></h3>
                <p class="mb-0 opacity-75 small">Add a new academic subject to the curriculum.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schSubject) ?>
                <fieldset class="border-0 p-0 m-0">
                    <div class="mb-4">
                        <?= $this->Form->control('name', [
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. Mathematics, English, Sciences',
                            'label' => ['text' => 'Subject Name', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('class_id', [
                            'options' => $schClasses,
                            'empty' => 'General (Not Assigned to specific class)',
                            'class' => 'form-select form-select-lg bg-light border-0',
                            'label' => ['text' => 'Assigned Class (Optional)', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                </fieldset>
                <div class="d-grid gap-2 mt-5">
                    <?= $this->Form->button(__('Create Subject'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
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
