<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Meeting $meeting
 * @var string[]|\Cake\Collection\CollectionInterface $contacts
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $meeting->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Meetings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="meetings form content">
            <?= $this->Form->create($meeting) ?>
            <fieldset>
                <legend><?= __('Edit Meeting') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('contact_id', ['options' => $contacts, 'empty' => true]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('agenda');
                    echo $this->Form->control('outcomes');
                    echo $this->Form->control('attachments');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
