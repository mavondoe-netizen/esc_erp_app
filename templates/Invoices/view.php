<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Company $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <a href="#" onclick="window.print();" class="side-nav-item">Print Invoice</a>
            <?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoices view content">
            
            <div class="row print-header" style="margin-bottom: 20px;">
                <div class="column">
                    <?php if ($company->logo): ?>
                        <img src="<?= h($company->logo) ?>" style="max-height: 80px;" alt="Logo" />
                    <?php else: ?>
                        <h3><?= h($company->name) ?></h3>
                    <?php endif; ?>
                    <p style="margin-top: 10px;">
                        <?= nl2br(h($company->address)) ?><br>
                        <?= h($company->email) ?> | <?= h($company->phone) ?>
                    </p>
                </div>
                <div class="column" style="text-align: right;">
                    <h2>INVOICE</h2>
                    <strong>Invoice #:</strong> <?= h($invoice->id) ?><br>
                    <strong>Date:</strong> <?= h($invoice->date) ?><br>
                    <strong>Currency:</strong> <?= h($invoice->currency) ?>
                </div>
            </div>

            <table class="table">
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $invoice->hasValue('customer') ? $this->Html->link($invoice->customer->name, ['controller' => 'Customers', 'action' => 'view', $invoice->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($invoice->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($invoice->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($invoice->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($invoice->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->currency($invoice->total, $invoice->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($invoice->date) ?></td>
                </tr>
            </table>
            
            <div class="related">
                <h4><?= __('Invoice Items') ?></h4>
                <?php if (!empty($invoice->invoice_items)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Product') ?></th>
                            <th><?= __('Description') ?></th>
                            <th class="text-center"><?= __('Quantity') ?></th>
                            <th class="text-right"><?= __('Unit Price') ?></th>
                            <th class="text-right"><?= __('Vat Rate') ?></th>
                            <th class="text-right"><?= __('Vat Amount') ?></th>
                            <th class="text-right"><?= __('Line Total') ?></th>
                        </tr>
                        <?php 
                        $subtotal = 0;
                        $totalVat = 0;
                        foreach ($invoice->invoice_items as $item) : 
                            $vatAmount = $item->vat_amount ?? 0;
                            $basePrice = $item->quantity * $item->unit_price;
                            $subtotal += $basePrice;
                            $totalVat += $vatAmount;
                        ?>
                        <tr>
                            <td><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></td>
                            <td><?= h($item->description) ?></td>
                            <td class="text-center"><?= $this->Number->format($item->quantity) ?></td>
                            <td class="text-right"><?= $this->Number->currency($item->unit_price, $invoice->currency) ?></td>
                            <td class="text-right"><?= $this->Number->format($item->vat_rate) ?>%</td>
                            <td class="text-right"><?= $this->Number->currency($item->vat_amount, $invoice->currency) ?></td>
                            <td class="text-right"><?= $this->Number->currency($item->line_total, $invoice->currency) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <tr>
                            <td colspan="6" class="text-right"><strong>Subtotal:</strong></td>
                            <td class="text-right"><?= $this->Number->currency($subtotal, $invoice->currency) ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Total VAT:</strong></td>
                            <td class="text-right"><?= $this->Number->currency($totalVat, $invoice->currency) ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Grand Total:</strong></td>
                            <td class="text-right" style="font-weight: bold; font-size: 1.1em;"><?= $this->Number->currency($invoice->total, $invoice->currency) ?></td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($invoice->transactions)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th class="text-right"><?= __('Amount') ?></th>
                            <th class="text-right"><?= __('Zwg') ?></th>
                            <th><?= __('Type') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($invoice->transactions as $transaction) : ?>
                        <tr>
                            <td><?= h($transaction->id) ?></td>
                            <td><?= h($transaction->date) ?></td>
                            <td><?= h($transaction->description) ?></td>
                            <td><?= h($transaction->currency) ?></td>
                            <td class="text-right"><?= $this->Number->format($transaction->amount) ?></td>
                            <td class="text-right"><?= $this->Number->format($transaction->zwg) ?></td>
                            <td><?= h($transaction->type) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transaction->id]) ?>
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

<style>
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
    @media print {
        body * { visibility: hidden; }
        .invoices.view.content, .invoices.view.content * { visibility: visible; }
        .invoices.view.content { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
        .actions, .side-nav, .navigation, nav { display: none !important; }
        .column-80 { width: 100% !important; max-width: 100% !important; flex: 0 0 100% !important; margin: 0; padding: 0; }
        .row { margin: 0; padding: 0; }
    }
</style>