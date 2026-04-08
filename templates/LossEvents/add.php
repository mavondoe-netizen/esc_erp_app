<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LossEvent $lossEvent
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $incidents
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Loss Events'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="lossEvents form content">
            <?= $this->Form->create($lossEvent) ?>
            <fieldset>
                <legend><?= __('Add Loss Event') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('incident_id', ['options' => $incidents]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('recovery_amount');
                    echo $this->Form->control('net_loss');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
