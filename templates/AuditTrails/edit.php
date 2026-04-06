<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditTrail $auditTrail
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $auditTrail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $auditTrail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Audit Trails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditTrails form content">
            <?= $this->Form->create($auditTrail) ?>
            <fieldset>
                <legend><?= __('Edit Audit Trail') ?></legend>
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
