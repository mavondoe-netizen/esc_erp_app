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
                    echo $this->Form->control('stage', ['options' => [
                        'Lead' => 'Lead',
                        'Qualified' => 'Qualified',
                        'Proposal' => 'Proposal',
                        'Negotiation' => 'Negotiation',
                        'Closed Won' => 'Closed Won',
                        'Closed Lost' => 'Closed Lost'
                    ]]);
                ?>
                <div class="quick-add-group">
                    <div class="form-control-wrapper">
                        <?= $this->Form->control('contact_id', ['options' => $contacts, 'id' => 'contact-id', 'empty' => true]) ?>
                    </div>
                    <button type="button" class="global-quick-add-btn button button-outline" data-url="/contacts/index?popup=1" data-target-dropdown="contact-id" title="Search/Pick Contact">
                        <i class="fa fa-search"></i>
                    </button>
                    <button type="button" class="global-quick-add-btn button button-outline" data-url="/contacts/add?popup=1" data-target-dropdown="contact-id" title="Add New Contact">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <?php
                    echo $this->Form->control('status', ['options' => [
                        'Active' => 'Active',
                        'On Hold' => 'On Hold',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled'
                    ]]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
