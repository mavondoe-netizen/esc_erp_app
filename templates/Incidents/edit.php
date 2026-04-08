<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incident $incident
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $incident->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $incident->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Incidents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="incidents form content">
            <?= $this->Form->create($incident) ?>
            <fieldset>
                <legend><?= __('Edit Incident') ?></legend>
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
