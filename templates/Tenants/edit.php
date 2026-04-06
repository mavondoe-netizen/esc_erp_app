<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 * @var string[]|\Cake\Collection\CollectionInterface $contacts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tenant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tenants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenants form content">
            <?= $this->Form->create($tenant) ?>
            <fieldset>
                <legend><?= __('Edit Tenant') ?></legend>
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
