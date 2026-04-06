<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tenant'), ['action' => 'edit', $tenant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tenant'), ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tenants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tenant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenants view content">
            <h3><?= h($tenant->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($tenant->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact') ?></th>
                    <td><?= $tenant->hasValue('contact') ? $this->Html->link($tenant->contact->name, ['controller' => 'Contacts', 'action' => 'view', $tenant->contact->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tenant->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Enrolments') ?></h4>
                <?php if (!empty($tenant->enrolments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Unit Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Rate') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tenant->enrolments as $enrolment) : ?>
                        <tr>
                            <td><?= h($enrolment->id) ?></td>
                            <td><?= h($enrolment->tenant_id) ?></td>
                            <td><?= h($enrolment->unit_id) ?></td>
                            <td><?= h($enrolment->start_date) ?></td>
                            <td><?= h($enrolment->end_date) ?></td>
                            <td><?= h($enrolment->rate) ?></td>
                            <td><?= h($enrolment->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Enrolments', 'action' => 'view', $enrolment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Enrolments', 'action' => 'edit', $enrolment->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Enrolments', 'action' => 'delete', $enrolment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrolment->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($tenant->transactions)) : ?>
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
                        <?php foreach ($tenant->transactions as $transaction) : ?>
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