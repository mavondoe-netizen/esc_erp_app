<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExchangeRate $exchangeRate
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exchange Rates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="exchangeRates form content">
            <?= $this->Form->create($exchangeRate) ?>
            <fieldset>
                <legend><?= __('Add Exchange Rate') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('currency');
                    echo $this->Form->control('rate_to_base');
                    echo $this->Form->control('date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
