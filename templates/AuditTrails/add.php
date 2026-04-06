<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditTrail $auditTrail
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audit Trails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditTrails form content">
            <?= $this->Form->create($auditTrail) ?>
            <fieldset>
                <legend><?= __('Add Audit Trail') ?></legend>
                <?php
                    echo $this->Form->control('entity_type');
                    echo $this->Form->control('entity_id');
                    echo $this->Form->control('action');
                    echo $this->Form->control('description');
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
