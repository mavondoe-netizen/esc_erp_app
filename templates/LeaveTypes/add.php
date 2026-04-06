<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveType $leaveType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Leave Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveTypes form content">
            <?= $this->Form->create($leaveType) ?>
            <fieldset>
                <legend><?= __('Add Leave Type') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('default_days_per_year');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
