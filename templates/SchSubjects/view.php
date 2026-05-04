<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchSubject $schSubject
 */
?>
<div class="row">
    <div class="column column-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold text-dark mb-1"><?= h($schSubject->name) ?></h1>
                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 me-2">Subject Details</span>
            </div>
            <div class="btn-group shadow-sm">
                <?= $this->Html->link(__('Edit Subject'), ['action' => 'edit', $schSubject->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $schSubject->id], ['confirm' => __('Are you sure?'), 'class' => 'btn btn-outline-danger']) ?>
                <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'btn btn-light']) ?>
            </div>
        </div>

        <div class="row g-4">
            <div class="column column-50">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i><?= __('Subject Profile') ?></h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th class="text-muted" style="width: 30%;"><?= __('Subject Name') ?></th>
                                <td class="fw-bold"><?= h($schSubject->name) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted"><?= __('Assigned Class') ?></th>
                                <td>
                                    <?= $schSubject->hasValue('sch_class') ? $this->Html->link($schSubject->sch_class->name, ['controller' => 'SchClasses', 'action' => 'view', $schSubject->sch_class->id], ['class' => 'text-decoration-none fw-medium text-primary']) : '<span class="text-muted italic">Not Assigned</span>' ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted"><?= __('Created') ?></th>
                                <td><?= h($schSubject->created) ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted"><?= __('Modified') ?></th>
                                <td><?= h($schSubject->modified) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
