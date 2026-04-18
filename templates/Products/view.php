<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="products view content">
            <h3><?= h($product->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($product->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $product->hasValue('account') ? $this->Html->link($product->account->name, ['controller' => 'Accounts', 'action' => 'view', $product->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($product->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($product->unit_price, ['places' => 2]) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vat Rate') ?></th>
                    <td><?= $this->Number->format($product->vat_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vat Type') ?></th>
                    <td><?= h($product->vat_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('HS Code') ?></th>
                    <td><?= h($product->hs_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($product->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($product->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Invoice Items') ?></h4>
                <?php if (!empty($product->invoice_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Unit Price') ?></th>
                            <th><?= __('Line Total') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->invoice_items as $invoiceItem) : ?>
                        <tr>
                            <td><?= h($invoiceItem->id) ?></td>
                            <td><?= h($invoiceItem->invoice_id) ?></td>
                            <td><?= h($invoiceItem->account_id) ?></td>
                            <td><?= h($invoiceItem->quantity) ?></td>
                            <td><?= h($invoiceItem->unit_price) ?></td>
                            <td><?= h($invoiceItem->line_total) ?></td>
                            <td><?= h($invoiceItem->product_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InvoiceItems', 'action' => 'view', $invoiceItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceItems', 'action' => 'edit', $invoiceItem->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceItems', 'action' => 'delete', $invoiceItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>