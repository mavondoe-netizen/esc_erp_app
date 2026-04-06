<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Building $building
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Building'), ['action' => 'edit', $building->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Building'), ['action' => 'delete', $building->id], ['confirm' => __('Are you sure you want to delete # {0}?', $building->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Buildings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Building'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="buildings view content">
            <h3><?= h($building->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($building->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($building->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Investor') ?></th>
                    <td><?= $building->hasValue('investor') ? $this->Html->link($building->investor->name, ['controller' => 'Investors', 'action' => 'view', $building->investor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($building->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($building->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Isvacant') ?></th>
                    <td><?= $building->isvacant ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Bills') ?></h4>
                <?php if (!empty($building->bills)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Building Id') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($building->bills as $bill) : ?>
                        <tr>
                            <td><?= h($bill->id) ?></td>
                            <td><?= h($bill->supplier_id) ?></td>
                            <td><?= h($bill->description) ?></td>
                            <td><?= h($bill->account_id) ?></td>
                            <td><?= h($bill->building_id) ?></td>
                            <td><?= h($bill->currency) ?></td>
                            <td><?= h($bill->amount) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Bills', 'action' => 'view', $bill->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Bills', 'action' => 'edit', $bill->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Bills', 'action' => 'delete', $bill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bill->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($building->transactions)) : ?>
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
                        <?php foreach ($building->transactions as $transaction) : ?>
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
            <div class="related">
                <h4><?= __('Related Units') ?></h4>
                <?php if (!empty($building->units)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Building Id') ?></th>
                            <th><?= __('Area') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($building->units as $unit) : ?>
                        <tr>
                            <td><?= h($unit->id) ?></td>
                            <td><?= h($unit->name) ?></td>
                            <td><?= h($unit->building_id) ?></td>
                            <td><?= h($unit->area) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Units', 'action' => 'view', $unit->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Units', 'action' => 'edit', $unit->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Units', 'action' => 'delete', $unit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id)]) ?>
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