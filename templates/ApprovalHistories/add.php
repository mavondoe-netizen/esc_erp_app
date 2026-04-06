<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalHistory $approvalHistory
 * @var \Cake\Collection\CollectionInterface|string[] $approvals
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Approval Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalHistories form content">
            <?= $this->Form->create($approvalHistory) ?>
            <fieldset>
                <legend><?= __('Add Approval History') ?></legend>
                <?php
                    echo $this->Form->control('approval_id', ['options' => $approvals]);
                    echo $this->Form->control('action');
                    echo $this->Form->control('level');
                    echo $this->Form->control('performed_by');
                    echo $this->Form->control('remarks');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
