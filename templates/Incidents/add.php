<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incident $incident
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Incidents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="incidents form content">
            <?= $this->Form->create($incident) ?>
            <fieldset>
                <legend><?= __('Add Incident') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('type');
                    echo $this->Form->control('business_unit_id');
                    echo $this->Form->control('reported_by');
                    echo $this->Form->control('reported_at', ['empty' => true]);
                    echo $this->Form->control('severity');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
