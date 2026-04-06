<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Earning $earning
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var array $zimraOptions
 * @var array $calculationTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Earnings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="earnings form content">
            <?= $this->Form->create($earning) ?>
            <fieldset>
                <legend><?= __('Add Earning') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('taxable');
                    echo $this->Form->control('pensionable');
                    echo $this->Form->control('nssa_applicable');
                    echo $this->Form->control('calculation_type', ['options' => $calculationTypes]);
                    echo $this->Form->control('zimra_mapping', ['options' => $zimraOptions, 'empty' => true]);
                    echo '<hr>';
                    echo '<h5>Advanced Logic Settings</h5>';
                    echo '<div class="row">';
                    echo '<div class="column column-33">' . $this->Form->control('gross_up', ['label' => 'Gross Up (Iterative Calculation)']) . '</div>';
                    echo '<div class="column column-33">' . $this->Form->control('taxable_percentage', ['type' => 'number', 'step' => '0.01', 'default' => 100.00, 'label' => 'Taxable Percentage (%)']) . '</div>';
                    echo '<div class="column column-33">' . $this->Form->control('tax_free_amount', ['type' => 'number', 'step' => '0.01', 'default' => 0.00, 'label' => 'Tax-Free Threshold (Fixed Amt)']) . '</div>';
                    echo '</div>';
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
