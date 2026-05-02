<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tender $tender
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tender'), ['action' => 'edit', $tender->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tender'), ['action' => 'delete', $tender->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tender->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tenders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tender'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenders view content">
            <h3><?= h($tender->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Procurement') ?></th>
                    <td><?= $tender->hasValue('procurement') ? $this->Html->link($tender->procurement->procurement_method, ['controller' => 'Procurements', 'action' => 'view', $tender->procurement->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($tender->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($tender->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $tender->hasValue('company') ? $this->Html->link($tender->company->name, ['controller' => 'Companies', 'action' => 'view', $tender->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tender->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Closing Date') ?></th>
                    <td><?= h($tender->closing_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($tender->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($tender->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tender->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Awards') ?></h4>
                <?php if (!empty($tender->awards)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Awarded Amount') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tender->awards as $award) : ?>
                        <tr>
                            <td><?= h($award->id) ?></td>
                            <td><?= h($award->supplier_id) ?></td>
                            <td><?= h($award->awarded_amount) ?></td>
                            <td><?= h($award->status) ?></td>
                            <td><?= h($award->company_id) ?></td>
                            <td><?= h($award->created) ?></td>
                            <td><?= h($award->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Awards', 'action' => 'view', $award->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Awards', 'action' => 'edit', $award->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Awards', 'action' => 'delete', $award->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $award->id),
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
                <h4><?= __('Related Evaluations') ?></h4>
                <?php if (!empty($tender->evaluations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Evaluator Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Technical Score') ?></th>
                            <th><?= __('Financial Score') ?></th>
                            <th><?= __('Comments') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tender->evaluations as $evaluation) : ?>
                        <tr>
                            <td><?= h($evaluation->id) ?></td>
                            <td><?= h($evaluation->evaluator_id) ?></td>
                            <td><?= h($evaluation->supplier_id) ?></td>
                            <td><?= h($evaluation->technical_score) ?></td>
                            <td><?= h($evaluation->financial_score) ?></td>
                            <td><?= h($evaluation->comments) ?></td>
                            <td><?= h($evaluation->company_id) ?></td>
                            <td><?= h($evaluation->created) ?></td>
                            <td><?= h($evaluation->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Evaluations', 'action' => 'view', $evaluation->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Evaluations', 'action' => 'edit', $evaluation->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Evaluations', 'action' => 'delete', $evaluation->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $evaluation->id),
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
                <h4><?= __('Related Tender Bids') ?></h4>
                <?php if (!empty($tender->tender_bids)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Bid Amount') ?></th>
                            <th><?= __('Technical Score') ?></th>
                            <th><?= __('Financial Score') ?></th>
                            <th><?= __('Total Score') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tender->tender_bids as $tenderBid) : ?>
                        <tr>
                            <td><?= h($tenderBid->id) ?></td>
                            <td><?= h($tenderBid->supplier_id) ?></td>
                            <td><?= h($tenderBid->bid_amount) ?></td>
                            <td><?= h($tenderBid->technical_score) ?></td>
                            <td><?= h($tenderBid->financial_score) ?></td>
                            <td><?= h($tenderBid->total_score) ?></td>
                            <td><?= h($tenderBid->status) ?></td>
                            <td><?= h($tenderBid->company_id) ?></td>
                            <td><?= h($tenderBid->created) ?></td>
                            <td><?= h($tenderBid->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TenderBids', 'action' => 'view', $tenderBid->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TenderBids', 'action' => 'edit', $tenderBid->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'TenderBids', 'action' => 'delete', $tenderBid->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $tenderBid->id),
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