<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Kri $kri
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $risks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Kris'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="kris form content">
            <?= $this->Form->create($kri) ?>
            <fieldset>
                <legend><?= __('Add Kri') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('risk_id', ['options' => $risks]);
                    echo $this->Form->control('metric');
                    echo $this->Form->control('threshold');
                    echo $this->Form->control('current_value');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
