<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ZimraReconciliation $zimraReconciliation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reconciliations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="zimraReconciliations form content">
            <?= $this->Form->create($zimraReconciliation) ?>
            <fieldset>
                <legend><?= __('Clear Variance via Ledger Resolution for ') . h($zimraReconciliation->employee->first_name . ' ' . $zimraReconciliation->employee->last_name) ?></legend>
                <div style="background:#f8f9fa; padding:15px; margin-bottom:20px; border-radius:5px;">
                    <strong>Variance Amount:</strong> $<?= number_format((float)$zimraReconciliation->variance, 2) ?><br/>
                    <em>Please provide the reference number of the Payment or Receipt transaction used to clear this balance at year-end or month-end.</em>
                </div>
                <?php
                    echo $this->Form->control('cleared_via', ['label' => 'Payment/Receipt Ledger Reference', 'required' => true, 'placeholder' => 'e.g. RCPT-2026-0092']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit Clearance')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
