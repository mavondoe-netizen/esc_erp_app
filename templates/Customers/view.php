<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customers view content">
            <h3><?= h($customer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($customer->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact') ?></th>
                    <td><?= $customer->hasValue('contact') ? $this->Html->link($customer->contact->name, ['controller' => 'Contacts', 'action' => 'view', $customer->contact->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspections') ?></h4>
                <?php if (!empty($customer->inspections)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Pobs Insurable') ?></th>
                            <th><?= __('Apwcs Insurable') ?></th>
                            <th><?= __('Apwcs Penalty') ?></th>
                            <th><?= __('Inspector Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->inspections as $inspection) : ?>
                        <tr>
                            <td><?= h($inspection->id) ?></td>
                            <td><?= h($inspection->name) ?></td>
                            <td><?= h($inspection->customer_id) ?></td>
                            <td><?= h($inspection->date) ?></td>
                            <td><?= h($inspection->pobs_insurable) ?></td>
                            <td><?= h($inspection->apwcs_insurable) ?></td>
                            <td><?= h($inspection->apwcs_penalty) ?></td>
                            <td><?= h($inspection->inspector_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Inspections', 'action' => 'view', $inspection->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Inspections', 'action' => 'edit', $inspection->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Inspections', 'action' => 'delete', $inspection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($customer->invoices)) : ?>
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
                        <?php foreach ($customer->invoices as $invoice) : ?>
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
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($customer->payments)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Mode') ?></th>
                            <th><?= __('Reference') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->payments as $payment) : ?>
                        <tr>
                            <td><?= h($payment->id) ?></td>
                            <td><?= h($payment->date) ?></td>
                            <td><?= h($payment->amount) ?></td>
                            <td><?= h($payment->currency) ?></td>
                            <td><?= h($payment->payment_mode) ?></td>
                            <td><?= h($payment->reference) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payment->id]) ?>
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