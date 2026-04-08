<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Regulation $regulation
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $regulation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $regulation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Regulations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="regulations form content">
            <?= $this->Form->create($regulation) ?>
            <fieldset>
                <legend><?= __('Edit Regulation') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('regulator');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
