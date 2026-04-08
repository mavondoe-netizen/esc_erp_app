<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ControlTest $controlTest
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $controls
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $controlTest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $controlTest->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Control Tests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="controlTests form content">
            <?= $this->Form->create($controlTest) ?>
            <fieldset>
                <legend><?= __('Edit Control Test') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('control_id', ['options' => $controls]);
                    echo $this->Form->control('test_result');
                    echo $this->Form->control('tested_by');
                    echo $this->Form->control('tested_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
