<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enrolment $enrolment
 * @var \Cake\Collection\CollectionInterface|string[] $tenants
 * @var \Cake\Collection\CollectionInterface|string[] $units
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Enrolments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="enrolments form content">
            <?= $this->Form->create($enrolment) ?>
            <fieldset>
                <legend><?= __('Add Enrolment') ?></legend>
                <?php
                    echo $this->Form->control('tenant_id', ['options' => $tenants]);
                    echo $this->Form->control('unit_id', ['options' => $units]);
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date', ['empty' => true]);
                    echo $this->Form->control('rate');
                    echo $this->Form->control('status',['options'=>['Pending'=> 'Pending', 'Terminated'=> 'Terminated']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
