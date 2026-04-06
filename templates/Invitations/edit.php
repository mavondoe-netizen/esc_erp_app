<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invitation $invitation
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invitation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Invitations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invitations form content">
            <?= $this->Form->create($invitation) ?>
            <fieldset>
                <legend><?= __('Edit Invitation') ?></legend>
                <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('role_id', ['options' => $roles]);
                    echo $this->Form->control('token');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
