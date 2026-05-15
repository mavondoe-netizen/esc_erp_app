<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchTeacher $schTeacher
 * @var array $users
 * @var array $employees
 * @var string $employeesJson
 */
?>
<div class="row justify-content-center">
    <div class="column column-50">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-4 px-4 border-0">
                <h3 class="mb-0 fw-bold"><?= __('Add Teacher Profile') ?></h3>
                <p class="mb-0 opacity-75 small">Register a new teaching staff member.</p>
            </div>
            <div class="card-body p-4">
                <?= $this->Form->create($schTeacher) ?>
                <fieldset class="border-0 p-0 m-0">
                    <div class="mb-4">
                        <?= $this->Form->control('user_id', [
                            'options' => $users,
                            'empty'   => 'Select Associated System User',
                            'class'   => 'form-select form-select-lg bg-light border-0',
                            'label'   => ['text' => 'System User Account', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('employee_id', [
                            'options' => $employees,
                            'empty'   => '— Link to HR Employee Record (Optional) —',
                            'class'   => 'form-select form-select-lg bg-light border-0',
                            'label'   => ['text' => 'HR Employee Record', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('employee_no', [
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. EMP-1045',
                            'label' => ['text' => 'Employee Number', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                    <div class="mb-4">
                        <?= $this->Form->control('specialty', [
                            'class' => 'form-control form-control-lg bg-light border-0',
                            'placeholder' => 'e.g. Mathematics, Sciences, PE',
                            'label' => ['text' => 'Teaching Specialty', 'class' => 'form-label fw-bold small text-muted text-uppercase mb-2']
                        ]) ?>
                    </div>
                </fieldset>
                <div class="d-grid gap-2 mt-5">
                    <?= $this->Form->button(__('Save Teacher'), ['class' => 'btn btn-primary btn-lg shadow-sm border-0']) ?>
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
@keyframes autofill-pulse {
    0%   { background-color: #eff6ff; }
    60%  { background-color: #dbeafe; }
    100% { background-color: #fff; }
}
.autofilled { animation: autofill-pulse 0.7s ease; }
</style>

<script>
(function () {
    const empData   = <?= $employeesJson ?>;
    const empSelect = document.getElementById('employee-id');
    const empNoInput = document.getElementById('employee-no');

    if (!empSelect || !empNoInput) return;

    empSelect.addEventListener('change', function () {
        const selected = empData[this.value];
        if (selected) {
            empNoInput.value = selected.employee_no;
            // visual feedback
            empNoInput.classList.remove('autofilled');
            void empNoInput.offsetWidth; // reflow to restart animation
            empNoInput.classList.add('autofilled');
        }
    });
})();
</script>
