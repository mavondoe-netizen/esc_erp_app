<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ExchangeRate> $exchangeRates
 */
?>
<div class="exchangeRates index content">
    <?= $this->Html->link(__('New Exchange Rate'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exchange Rates') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('rate_to_base') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exchangeRates as $exchangeRate): ?>
                <tr>
                    <td><?= $this->Number->format($exchangeRate->id) ?></td>
                    <td><?= $exchangeRate->hasValue('company') ? $this->Html->link($exchangeRate->company->name, ['controller' => 'Companies', 'action' => 'view', $exchangeRate->company->id]) : '' ?></td>
                    <td><?= h($exchangeRate->currency) ?></td>
                    <td><?= $this->Number->format($exchangeRate->rate_to_base) ?></td>
                    <td><?= h($exchangeRate->date) ?></td>
                    <td><?= h($exchangeRate->created) ?></td>
                    <td><?= h($exchangeRate->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exchangeRate->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exchangeRate->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exchangeRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exchangeRate->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>