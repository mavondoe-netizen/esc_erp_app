<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Repair $repair
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $units
 * @var string[]|\Cake\Collection\CollectionInterface $buildings
 * @var string[]|\Cake\Collection\CollectionInterface $tenants
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $repair->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $repair->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Repairs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="repairs form content">
            <?= $this->Form->create($repair) ?>
            <fieldset>
                <legend><?= __('Edit Repair') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('unit_id', ['options' => $units, 'empty' => true]);
                    echo $this->Form->control('building_id', ['options' => $buildings, 'empty' => true]);
                    echo $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category');
                    echo $this->Form->control('status');
                    echo $this->Form->control('reported_date', ['empty' => true]);
                    echo $this->Form->control('resolved_date', ['empty' => true]);
                    echo $this->Form->control('cost');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
