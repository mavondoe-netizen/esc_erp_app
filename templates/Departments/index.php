<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Department> $departments
 */
?>
<div class="departments index content">
    <div class="index-header">
        <h2 class="index-title"><i class="fas fa-layer-group"></i> Departments</h2>
        <div class="actions">
            <?= $this->Html->link(__('<i class="fas fa-plus"></i> New Department'), ['action' => 'add'], ['class' => 'button', 'escape' => false]) ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table hover-rows">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                <tr>
                    <td><?= $this->Number->format($department->id) ?></td>
                    <td class="primary-text"><?= h($department->name) ?></td>
                    <td><?= h($department->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('<i class="fas fa-edit"></i>'), ['action' => 'edit', $department->id], ['class' => 'action-icon edit', 'title' => 'Edit', 'escape' => false]) ?>
                        <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete # {0}?', $department->id), 'class' => 'action-icon delete', 'title' => 'Delete', 'escape' => false]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
