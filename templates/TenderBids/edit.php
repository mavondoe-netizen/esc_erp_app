<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenderBid $tenderBid
 * @var string[]|\Cake\Collection\CollectionInterface $tenders
 * @var string[]|\Cake\Collection\CollectionInterface $suppliers
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tenderBid->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tenderBid->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tender Bids'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenderBids form content">
            <?= $this->Form->create($tenderBid) ?>
            <fieldset>
                <legend><?= __('Edit Tender Bid') ?></legend>
                <?php
                    echo $this->Form->control('tender_id', ['options' => $tenders]);
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('bid_amount');
                    echo $this->Form->control('technical_score');
                    echo $this->Form->control('financial_score');
                    echo $this->Form->control('total_score');
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
