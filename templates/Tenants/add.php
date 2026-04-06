<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 * @var \Cake\Collection\CollectionInterface|string[] $contacts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tenants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenants form content">
            <?= $this->Form->create($tenant) ?>
            <fieldset>
                <legend><?= __('Add Tenant') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('contact_id', ['options' => $contacts, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
