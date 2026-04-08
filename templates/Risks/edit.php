<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Risk $risk
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $risk->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $risk->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Risks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="risks form content">
            <?= $this->Form->create($risk) ?>
            <fieldset>
                <legend><?= __('Edit Risk') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category');
                    echo $this->Form->control('business_unit_id');
                    echo $this->Form->control('owner_id');
                    echo $this->Form->control('inherent_risk_score');
                    echo $this->Form->control('residual_risk_score');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
