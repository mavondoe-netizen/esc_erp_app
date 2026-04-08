<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Risk $risk
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Risks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="risks form content">
            <?= $this->Form->create($risk) ?>
            <fieldset>
                <legend><?= __('Add Risk') ?></legend>
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
