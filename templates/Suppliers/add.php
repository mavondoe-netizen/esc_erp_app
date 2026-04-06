<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 * @var \Cake\Collection\CollectionInterface|string[] $contacts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Suppliers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="suppliers form content">
            <?= $this->Form->create($supplier) ?>
            <fieldset>
                <legend><?= __('Add Supplier') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('contact_id', ['options' => $contacts]);
                    echo $this->Form->control('industry');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
