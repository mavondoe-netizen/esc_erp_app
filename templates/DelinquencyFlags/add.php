<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DelinquencyFlag $delinquencyFlag
 * @var \Cake\Collection\CollectionInterface|string[] $loans
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Delinquency Flags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="delinquencyFlags form content">
            <?= $this->Form->create($delinquencyFlag) ?>
            <fieldset>
                <legend><?= __('Add Delinquency Flag') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('days_overdue');
                    echo $this->Form->control('amount_overdue');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('category');
                    echo $this->Form->control('flagged_at', ['empty' => true]);
                    echo $this->Form->control('resolved_at', ['empty' => true]);
                    echo $this->Form->control('notification_sent');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
