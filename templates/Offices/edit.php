<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Office $office
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $office->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $office->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Offices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="offices form content">
            <?= $this->Form->create($office) ?>
            <fieldset>
                <legend><?= __('Edit Office') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('location');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
