<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Account'), ['action' => 'edit', $account->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Account'), ['action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Accounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Account'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="accounts view content">
            <h3><?= h($account->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($account->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($account->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subcategory') ?></th>
                    <td><?= h($account->subcategory) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($account->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($account->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($account->invoices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Total') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($account->invoices as $invoice) : ?>
                        <tr>
                            <td><?= h($invoice->id) ?></td>
                            <td><?= h($invoice->date) ?></td>
                            <td><?= h($invoice->customer_id) ?></td>
                            <td><?= h($invoice->currency) ?></td>
                            <td><?= h($invoice->description) ?></td>
                            <td><?= h($invoice->status) ?></td>
                            <td><?= h($invoice->total) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoice->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoice->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invoices', 'action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="related">
                <h4><?= __('Related Bill Items') ?></h4>
                <?php if (!empty($account->bill_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Bill Id') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Unit Price') ?></th>
                            <th><?= __('Line Total') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($account->bill_items as $billItem) : ?>
                        <tr>
                            <td><?= h($billItem->id) ?></td>
                            <td><?= h($billItem->bill_id) ?></td>
                            <td><?= h($billItem->account_id) ?></td>
                            <td><?= h($billItem->quantity) ?></td>
                            <td><?= h($billItem->unit_price) ?></td>
                            <td><?= h($billItem->line_total) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'BillItems', 'action' => 'view', $billItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'BillItems', 'action' => 'edit', $billItem->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'BillItems', 'action' => 'delete', $billItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $billItem->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Items') ?></h4>
                <?php if (!empty($account->invoice_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Unit Price') ?></th>
                            <th><?= __('Line Total') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($account->invoice_items as $invoiceItem) : ?>
                        <tr>
                            <td><?= h($invoiceItem->id) ?></td>
                            <td><?= h($invoiceItem->invoice_id) ?></td>
                            <td><?= h($invoiceItem->account_id) ?></td>
                            <td><?= h($invoiceItem->quantity) ?></td>
                            <td><?= h($invoiceItem->unit_price) ?></td>
                            <td><?= h($invoiceItem->line_total) ?></td>
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
            <div class="related">
                <h4><?= __('Related Receipts') ?></h4>
                <?php if (!empty($account->receipts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($account->receipts as $receipt) : ?>
                        <tr>
                            <td><?= h($receipt->id) ?></td>
                            <td><?= h($receipt->contact_id) ?></td>
                            <td><?= h($receipt->currency) ?></td>
                            <td><?= h($receipt->amount) ?></td>
                            <td><?= h($receipt->account_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Receipts', 'action' => 'view', $receipt->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Receipts', 'action' => 'edit', $receipt->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Receipts', 'action' => 'delete', $receipt->id], ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($account->transactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Zwg') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Building Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($account->transactions as $transaction) : ?>
                        <tr>
                            <td><?= h($transaction->id) ?></td>
                            <td><?= h($transaction->date) ?></td>
                            <td><?= h($transaction->description) ?></td>
                            <td><?= h($transaction->currency) ?></td>
                            <td><?= h($transaction->amount) ?></td>
                            <td><?= h($transaction->zwg) ?></td>
                            <td><?= h($transaction->account_id) ?></td>
                            <td><?= h($transaction->building_id) ?></td>
                            <td><?= h($transaction->tenant_id) ?></td>
                            <td><?= h($transaction->supplier_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transaction->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transactions', 'action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
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