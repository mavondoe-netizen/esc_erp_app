<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Approval $approval
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $approval->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $approval->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Approvals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvals form content">
            <?= $this->Form->create($approval) ?>
            <fieldset>
                <legend><?= __('Edit Approval') ?></legend>
                <?php
                    echo $this->Form->control('table_name');
                    echo $this->Form->control('entity_id');
                    echo $this->Form->control('status');
                    echo $this->Form->control('level');
                    echo $this->Form->control('initiated_by');
                    echo $this->Form->control('approved_by');
                    echo $this->Form->control('remarks');
                    echo $this->Form->control('approved_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
