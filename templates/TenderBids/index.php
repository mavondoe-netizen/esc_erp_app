<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TenderBid> $tenderBids
 */
?>
<div class="tenderBids index content">
    <?= $this->Html->link(__('New Tender Bid'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tender Bids') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tender_id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('bid_amount') ?></th>
                    <th><?= $this->Paginator->sort('technical_score') ?></th>
                    <th><?= $this->Paginator->sort('financial_score') ?></th>
                    <th><?= $this->Paginator->sort('total_score') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenderBids as $tenderBid): ?>
                <tr>
                    <td><?= $this->Number->format($tenderBid->id) ?></td>
                    <td><?= $tenderBid->hasValue('tender') ? $this->Html->link($tenderBid->tender->title, ['controller' => 'Tenders', 'action' => 'view', $tenderBid->tender->id]) : '' ?></td>
                    <td><?= $tenderBid->hasValue('supplier') ? $this->Html->link($tenderBid->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $tenderBid->supplier->id]) : '' ?></td>
                    <td><?= $this->Number->format($tenderBid->bid_amount) ?></td>
                    <td><?= $tenderBid->technical_score === null ? '' : $this->Number->format($tenderBid->technical_score) ?></td>
                    <td><?= $tenderBid->financial_score === null ? '' : $this->Number->format($tenderBid->financial_score) ?></td>
                    <td><?= $tenderBid->total_score === null ? '' : $this->Number->format($tenderBid->total_score) ?></td>
                    <td><?= h($tenderBid->status) ?></td>
                    <td><?= $tenderBid->hasValue('company') ? $this->Html->link($tenderBid->company->name, ['controller' => 'Companies', 'action' => 'view', $tenderBid->company->id]) : '' ?></td>
                    <td><?= h($tenderBid->created) ?></td>
                    <td><?= h($tenderBid->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tenderBid->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tenderBid->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $tenderBid->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $tenderBid->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>