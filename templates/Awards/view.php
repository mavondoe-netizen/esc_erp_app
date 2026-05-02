<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Award $award
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Award'), ['action' => 'edit', $award->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Award'), ['action' => 'delete', $award->id], ['confirm' => __('Are you sure you want to delete # {0}?', $award->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Awards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Award'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="awards view content">
            <h3><?= h($award->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tender') ?></th>
                    <td><?= $award->hasValue('tender') ? $this->Html->link($award->tender->title, ['controller' => 'Tenders', 'action' => 'view', $award->tender->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier') ?></th>
                    <td><?= $award->hasValue('supplier') ? $this->Html->link($award->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $award->supplier->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($award->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $award->hasValue('company') ? $this->Html->link($award->company->name, ['controller' => 'Companies', 'action' => 'view', $award->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($award->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Awarded Amount') ?></th>
                    <td><?= $this->Number->format($award->awarded_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($award->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($award->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Bills') ?></h4>
                <?php if (!empty($award->bills)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Department Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($award->bills as $bill) : ?>
                        <tr>
                            <td><?= h($bill->id) ?></td>
                            <td><?= h($bill->company_id) ?></td>
                            <td><?= h($bill->supplier_id) ?></td>
                            <td><?= h($bill->tenant_id) ?></td>
                            <td><?= h($bill->date) ?></td>
                            <td><?= h($bill->description) ?></td>
                            <td><?= h($bill->status) ?></td>
                            <td><?= h($bill->currency) ?></td>
                            <td><?= h($bill->total) ?></td>
                            <td><?= h($bill->department_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Bills', 'action' => 'view', $bill->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Bills', 'action' => 'edit', $bill->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Bills', 'action' => 'delete', $bill->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $bill->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Contracts') ?></h4>
                <?php if (!empty($award->contracts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Contract Number') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Sla Terms') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($award->contracts as $contract) : ?>
                        <tr>
                            <td><?= h($contract->id) ?></td>
                            <td><?= h($contract->contract_number) ?></td>
                            <td><?= h($contract->start_date) ?></td>
                            <td><?= h($contract->end_date) ?></td>
                            <td><?= h($contract->sla_terms) ?></td>
                            <td><?= h($contract->status) ?></td>
                            <td><?= h($contract->company_id) ?></td>
                            <td><?= h($contract->created) ?></td>
                            <td><?= h($contract->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Contracts', 'action' => 'view', $contract->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Contracts', 'action' => 'edit', $contract->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Contracts', 'action' => 'delete', $contract->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $contract->id),
                                    ]
                                ) ?>
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