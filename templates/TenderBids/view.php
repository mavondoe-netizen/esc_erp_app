<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenderBid $tenderBid
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tender Bid'), ['action' => 'edit', $tenderBid->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tender Bid'), ['action' => 'delete', $tenderBid->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenderBid->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tender Bids'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tender Bid'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenderBids view content">
            <h3><?= h($tenderBid->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tender') ?></th>
                    <td><?= $tenderBid->hasValue('tender') ? $this->Html->link($tenderBid->tender->title, ['controller' => 'Tenders', 'action' => 'view', $tenderBid->tender->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier') ?></th>
                    <td><?= $tenderBid->hasValue('supplier') ? $this->Html->link($tenderBid->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $tenderBid->supplier->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($tenderBid->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $tenderBid->hasValue('company') ? $this->Html->link($tenderBid->company->name, ['controller' => 'Companies', 'action' => 'view', $tenderBid->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tenderBid->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bid Amount') ?></th>
                    <td><?= $this->Number->format($tenderBid->bid_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Technical Score') ?></th>
                    <td><?= $tenderBid->technical_score === null ? '' : $this->Number->format($tenderBid->technical_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Financial Score') ?></th>
                    <td><?= $tenderBid->financial_score === null ? '' : $this->Number->format($tenderBid->financial_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Score') ?></th>
                    <td><?= $tenderBid->total_score === null ? '' : $this->Number->format($tenderBid->total_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($tenderBid->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($tenderBid->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>