<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Employee> $employees
 */
$isPopup = $this->request->getQuery('popup');
?>
<div class="employees index content">
    <?php if (!$isPopup): ?>
        <?= $this->Html->link(__('New Employee'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Employees') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_code') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('designation') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $this->Number->format($employee->id) ?></td>
                    <td><?= h($employee->employee_code) ?></td>
                    <td><?= h($employee->first_name) ?></td>
                    <td><?= h($employee->last_name) ?></td>
                    <td><?= h($employee->designation) ?></td>
                    <td class="actions">
                        <?php if ($isPopup): ?>
                            <button type="button" class="button button-small select-item-btn" 
                                    data-id="<?= $employee->id ?>" 
                                    data-name="<?= h($employee->first_name . ' ' . $employee->last_name) ?>">
                                <?= __('Select') ?>
                            </button>
                        <?php else: ?>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $employee->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employee->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<?php if ($isPopup): ?>
<script>
document.querySelectorAll('.select-item-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        if (window.parent) {
            window.parent.postMessage({
                action: 'itemAdded', 
                id: id,
                name: name
            }, '*');
        }
    });
});
</script>
<?php endif; ?>