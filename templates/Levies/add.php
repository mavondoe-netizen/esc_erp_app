<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Levy $levy
 * @var array $tenants, $units, $buildings, $accounts, $levyTypes, $currencies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Levies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="levies form content">
            <?= $this->Form->create($levy) ?>
            <fieldset>
                <legend><?= __('Add Levy') ?></legend>
                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => '-- Select Tenant --']) ?>
                        <?= $this->Form->control('unit_id', ['options' => $units, 'empty' => '-- Select Unit --']) ?>
                        <?= $this->Form->control('building_id', ['options' => $buildings, 'empty' => '-- Select Building --']) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('levy_type', ['type' => 'select', 'options' => $levyTypes, 'label' => 'Levy Type']) ?>
                        <?= $this->Form->control('amount', ['type' => 'number', 'step' => '0.01']) ?>
                        <?= $this->Form->control('currency', ['type' => 'select', 'options' => $currencies]) ?>
                        <?= $this->Form->control('due_date', ['label' => 'Due Date']) ?>
                    </div>
                </div>
                <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 3]) ?>
            </fieldset>
            <?= $this->Form->button(__('Create Levy'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
