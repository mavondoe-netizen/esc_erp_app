<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invitation $invitation
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Invitations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invitations form content">
            <?= $this->Form->create($invitation) ?>
            <fieldset>
                <legend><?= __('Add Invitation') ?></legend>
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
