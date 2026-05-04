<?php
/**
 * @var \App\View\AppView $this
 * @var array $customers
 * @var array $suppliers
 * @var array $students
 */
?>
<div class="statements index content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><?= __('Financial Statements') ?></h2>
            <p class="text-muted small">Generate monthly activity statements for receivables and payables.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Customer Statement Card -->
        <div class="column column-33">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Customer Statement</h5>
                </div>
                <div class="card-body p-4">
                    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'view']]) ?>
                        <?= $this->Form->hidden('type', ['value' => 'customer']) ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Customer</label>
                            <?= $this->Form->select('id', $customers, ['empty' => 'Choose...', 'class' => 'form-select bg-light border-0', 'required' => true]) ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Month</label>
                            <?= $this->Form->date('start_date', ['value' => date('Y-m-01'), 'class' => 'form-control bg-light border-0']) ?>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary shadow-sm">View Statement</button>
                            <?= $this->Form->button(__('Email Statement'), ['type' => 'submit', 'formaction' => $this->Url->build(['action' => 'emailStatement']), 'class' => 'btn btn-outline-primary shadow-sm']) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <!-- Supplier Statement Card -->
        <div class="column column-33">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Supplier Statement</h5>
                </div>
                <div class="card-body p-4">
                    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'view']]) ?>
                        <?= $this->Form->hidden('type', ['value' => 'supplier']) ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Supplier</label>
                            <?= $this->Form->select('id', $suppliers, ['empty' => 'Choose...', 'class' => 'form-select bg-light border-0', 'required' => true]) ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Month</label>
                            <?= $this->Form->date('start_date', ['value' => date('Y-m-01'), 'class' => 'form-control bg-light border-0']) ?>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success shadow-sm">View Statement</button>
                            <?= $this->Form->button(__('Email Statement'), ['type' => 'submit', 'formaction' => $this->Url->build(['action' => 'emailStatement']), 'class' => 'btn btn-outline-success shadow-sm']) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <!-- Student Statement Card -->
        <div class="column column-33">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-indigo text-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-mortarboard me-2"></i>Student Statement</h5>
                </div>
                <div class="card-body p-4">
                    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'view']]) ?>
                        <?= $this->Form->hidden('type', ['value' => 'student']) ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Student</label>
                            <?= $this->Form->select('id', $students, ['empty' => 'Choose...', 'class' => 'form-select bg-light border-0', 'required' => true]) ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Month</label>
                            <?= $this->Form->date('start_date', ['value' => date('Y-m-01'), 'class' => 'form-control bg-light border-0']) ?>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-indigo shadow-sm text-white">View Statement</button>
                            <?= $this->Form->button(__('Email Statement'), ['type' => 'submit', 'formaction' => $this->Url->build(['action' => 'emailStatement']), 'class' => 'btn btn-outline-indigo shadow-sm']) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-indigo { background: #6610f2 !important; }
.btn-indigo { background: #6610f2 !important; }
.btn-indigo:hover { background: #520dc2 !important; }
</style>
