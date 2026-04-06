<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $event->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $event->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Events'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="events form content">
            <?= $this->Form->create($event) ?>
            <fieldset>
                <legend><?= __('Edit Event') ?></legend>
                <?php
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
