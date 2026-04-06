<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalHistory $approvalHistory
 * @var string[]|\Cake\Collection\CollectionInterface $approvals
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $approvalHistory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $approvalHistory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Approval Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalHistories form content">
            <?= $this->Form->create($approvalHistory) ?>
            <fieldset>
                <legend><?= __('Edit Approval History') ?></legend>
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
