<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Repair $repair
 * @var array $units, $buildings, $tenants, $accounts, $statuses, $categories, $currencies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Repairs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="repairs form content">
            <?= $this->Form->create($repair) ?>
            <fieldset>
                <legend><?= __('Log Repair Request') ?></legend>
                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('title', ['placeholder' => 'Brief description of the issue']) ?>
                        <?= $this->Form->control('category', ['type' => 'select', 'options' => $categories, 'empty' => '-- Category --']) ?>
                        <?= $this->Form->control('status', ['type' => 'select', 'options' => $statuses]) ?>
                        <?= $this->Form->control('reported_date', ['label' => 'Date Reported']) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('building_id', ['options' => $buildings, 'empty' => '-- Building --']) ?>
                        <?= $this->Form->control('unit_id', ['options' => $units, 'empty' => '-- Unit --']) ?>
                        <?= $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => '-- Tenant (optional) --']) ?>
                        <?= $this->Form->control('cost', ['type' => 'number', 'step' => '0.01', 'label' => 'Estimated Cost']) ?>
                        <?= $this->Form->control('currency', ['type' => 'select', 'options' => $currencies]) ?>
                        <?= $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Expense Account --', 'label' => 'Charge to Expense Account']) ?>
                    </div>
                </div>
                <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 4, 'label' => 'Full Description / Notes']) ?>
            </fieldset>
            <?= $this->Form->button(__('Log Repair'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
