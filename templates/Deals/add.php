<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deal $deal
 * @var \Cake\Collection\CollectionInterface|string[] $contacts
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Deals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deals form content">
            <?= $this->Form->create($deal) ?>
            <fieldset>
                <legend><?= __('Add Deal') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('date');
                    echo $this->Form->control('type');
                    echo $this->Form->control('value');
                    echo $this->Form->control('stage');
                    echo $this->Form->control('contact_id', ['options' => $contacts, 'empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('submitted_by');
                    echo $this->Form->control('submitted_at', ['empty' => true]);
                    echo $this->Form->control('approved_by');
                    echo $this->Form->control('approved_at', ['empty' => true]);
                    echo $this->Form->control('rejected_by');
                    echo $this->Form->control('rejected_at', ['empty' => true]);
                    echo $this->Form->control('rejection_reason');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
