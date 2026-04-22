<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
$isPopup = $this->request->getQuery('popup');
?>
<div class="products index content">
    <?php if (!$isPopup): ?>
        <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Products') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('vat_rate') ?></th>
                    <th><?= $this->Paginator->sort('vat_type') ?></th>
                    <th><?= $this->Paginator->sort('hs_code') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $this->Number->format($product->id) ?></td>
                    <td><?= h($product->name) ?></td>
                    <td><?= $product->hasValue('account') ? $this->Html->link($product->account->name, ['controller' => 'Accounts', 'action' => 'view', $product->account->id]) : '' ?></td>
                    <td><?= $this->Number->format($product->unit_price, ['places' => 2]) ?></td>
                    <td><?= $this->Number->format($product->vat_rate) ?></td>
                    <td><?= h($product->vat_type) ?></td>
                    <td><?= h($product->hs_code) ?></td>
                    <td class="actions">
                        <?php if ($isPopup): ?>
                            <button type="button" class="button button-small select-item-btn" 
                                    data-id="<?= $product->id ?>" 
                                    data-name="<?= h($product->name) ?>">
                                <?= __('Select') ?>
                            </button>
                        <?php else: ?>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
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