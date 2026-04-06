<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CreditNote $creditNote
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Credit Note'), ['action' => 'edit', $creditNote->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Credit Note'), ['action' => 'delete', $creditNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditNote->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Credit Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Credit Note'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="creditNotes view content">
            <h3><?= h($creditNote->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $creditNote->hasValue('company') ? $this->Html->link($creditNote->company->name, ['controller' => 'Companies', 'action' => 'view', $creditNote->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $creditNote->hasValue('customer') ? $this->Html->link($creditNote->customer->name, ['controller' => 'Customers', 'action' => 'view', $creditNote->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($creditNote->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($creditNote->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($creditNote->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $creditNote->total === null ? '' : $this->Number->format($creditNote->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($creditNote->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($creditNote->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($creditNote->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Credit Note Items') ?></h4>
                <?php if (!empty($creditNote->credit_note_items)) : ?>
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
                            foreach ($creditNote->credit_note_items as $item) : 
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
                                <td style="text-align: right; padding: 12px; font-size: 1.2rem; font-weight: bold; color: #0f172a;"><?= $this->Number->currency($creditNote->total) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>