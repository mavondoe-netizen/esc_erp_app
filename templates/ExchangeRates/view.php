<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExchangeRate $exchangeRate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exchange Rate'), ['action' => 'edit', $exchangeRate->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exchange Rate'), ['action' => 'delete', $exchangeRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exchangeRate->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exchange Rates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exchange Rate'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="exchangeRates view content">
            <h3><?= h($exchangeRate->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $exchangeRate->hasValue('company') ? $this->Html->link($exchangeRate->company->name, ['controller' => 'Companies', 'action' => 'view', $exchangeRate->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($exchangeRate->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exchangeRate->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rate To Base') ?></th>
                    <td><?= $this->Number->format($exchangeRate->rate_to_base) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($exchangeRate->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exchangeRate->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exchangeRate->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>