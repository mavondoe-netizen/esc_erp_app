<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estimate $estimate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Estimate'), ['action' => 'edit', $estimate->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Estimate'), ['action' => 'delete', $estimate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estimate->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Estimates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Estimate'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estimates view content">
            <h3><?= h($estimate->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $estimate->hasValue('company') ? $this->Html->link($estimate->company->name, ['controller' => 'Companies', 'action' => 'view', $estimate->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $estimate->hasValue('customer') ? $this->Html->link($estimate->customer->name, ['controller' => 'Customers', 'action' => 'view', $estimate->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($estimate->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($estimate->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($estimate->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $estimate->total === null ? '' : $this->Number->format($estimate->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($estimate->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expiry Date') ?></th>
                    <td><?= h($estimate->expiry_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($estimate->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($estimate->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Estimate Items') ?></h4>
                <?php if (!empty($estimate->estimate_items)) : ?>
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="text-align: left; padding: 12px;"><?= __('Product') ?></th>
                                <th style="text-align: center; padding: 12px;"><?= __('Qty') ?></th>
                                <th style="text-align: right; padding: 12px;"><?= __('Unit Price') ?></th>
                                <th style="text-align: right; padding: 12px;"><?= __('VAT %') ?></th>
                                <th style="text-align: right; padding: 12px;"><?= __('VAT Amount') ?></th>
                                <th style="text-align: right; padding: 12px;"><?= __('Line Total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $subtotal = 0;
                            $totalVat = 0;
                            foreach ($estimate->estimate_items as $item) : 
                                $subtotal += ($item->quantity * $item->unit_price);
                                $totalVat += $item->vat_amount;
                            ?>
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 12px;"><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></td>
                                <td style="text-align: center; padding: 12px;"><?= $this->Number->format($item->quantity) ?></td>
                                <td style="text-align: right; padding: 12px;"><?= $this->Number->currency($item->unit_price) ?></td>
                                <td style="text-align: right; padding: 12px;"><?= $this->Number->format($item->vat_rate) ?>%</td>
                                <td style="text-align: right; padding: 12px;"><?= $this->Number->currency($item->vat_amount) ?></td>
                                <td style="text-align: right; padding: 12px; font-weight: 600;"><?= $this->Number->currency($item->line_total) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right; padding: 12px; font-weight: bold;"><?= __('Subtotal') ?></td>
                                <td style="text-align: right; padding: 12px;"><?= $this->Number->currency($subtotal) ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: right; padding: 12px; font-weight: bold;"><?= __('Total VAT') ?></td>
                                <td style="text-align: right; padding: 12px;"><?= $this->Number->currency($totalVat) ?></td>
                            </tr>
                            <tr style="background: #f1f5f9;">
                                <td colspan="5" style="text-align: right; padding: 12px; font-size: 1.2rem; font-weight: bold;"><?= __('GRAND TOTAL') ?></td>
                                <td style="text-align: right; padding: 12px; font-size: 1.2rem; font-weight: bold; color: #0f172a;"><?= $this->Number->currency($estimate->total) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>