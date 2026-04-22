<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Supplier> $suppliers
 */
$isPopup = $this->request->getQuery('popup');
?>
<div class="suppliers index content">
    <?php if (!$isPopup): ?>
        <?= $this->Html->link(__('New Supplier'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Suppliers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('contact_id') ?></th>
                    <th><?= $this->Paginator->sort('industry') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                <tr>
                    <td><?= $this->Number->format($supplier->id) ?></td>
                    <td><?= h($supplier->name) ?></td>
                    <td><?= $supplier->hasValue('contact') ? $this->Html->link($supplier->contact->name, ['controller' => 'Contacts', 'action' => 'view', $supplier->contact->id]) : '' ?></td>
                    <td><?= h($supplier->industry) ?></td>
                    <td class="actions">
                        <?php if ($isPopup): ?>
                            <button type="button" class="button button-small select-item-btn" 
                                    data-id="<?= $supplier->id ?>" 
                                    data-name="<?= h($supplier->name) ?>">
                                <?= __('Select') ?>
                            </button>
                        <?php else: ?>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $supplier->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $supplier->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $supplier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]) ?>
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