<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalaryStructure $salaryStructure
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salaryStructure->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salaryStructure->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Salary Structures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="salaryStructures form content">
            <?= $this->Form->create($salaryStructure) ?>
            <fieldset>
                <legend><?= __('Edit Salary Structure') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('role_id', ['options' => $roles, 'empty' => true]);
                    echo $this->Form->control('currency');
                    echo $this->Form->control('basic_salary');
                    echo $this->Form->control('payment_frequency');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
