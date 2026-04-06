<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 * @var \Cake\Collection\CollectionInterface|string[] $contacts
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Emails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="emails form content">
            <?= $this->Form->create($email) ?>
            <fieldset>
                <legend><?= __('Add Email') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('contact_id', ['options' => $contacts]);
                    echo $this->Form->control('subject');
                    echo $this->Form->control('emailto');
                    echo $this->Form->control('emailfrom');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
