<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExchangeRate $exchangeRate
 * @var array $currencyOptions
 * @var \App\Model\Entity\Company|null $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exchangeRate->id],
                ['confirm' => __('Are you sure you want to delete this exchange rate?'), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exchange Rates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Add Exchange Rate'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="exchangeRates form content">
            <?= $this->Form->create($exchangeRate) ?>
            <fieldset>
                <legend><?= __('Edit Exchange Rate') ?></legend>
                <?php
                    // Company is locked to the current tenant — display as read-only
                    if ($company):
                ?>
                <div class="input">
                    <label><?= __('Company') ?></label>
                    <p style="padding: 6px 0; font-weight: bold;"><?= h($company->name) ?></p>
                    <?= $this->Form->hidden('company_id', ['value' => $company->id]) ?>
                </div>
                <?php else: ?>
                    <?= $this->Form->hidden('company_id') ?>
                <?php endif; ?>

                <?= $this->Form->control('currency', [
                    'type' => 'select',
                    'options' => $currencyOptions,
                    'empty' => '-- Select Currency --',
                    'label' => 'Currency (rate FROM this currency)',
                ]) ?>

                <?= $this->Form->control('rate_to_base', [
                    'label' => 'Rate to Base (e.g. 1 USD = X base units)',
                    'type' => 'number',
                    'step' => '0.000001',
                ]) ?>

                <?= $this->Form->control('date', [
                    'label' => 'Effective Date',
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Update Exchange Rate')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
