<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Kri $kri
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Kri'), ['action' => 'edit', $kri->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Kri'), ['action' => 'delete', $kri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kri->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Kris'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Kri'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="kris view content">
            <h3><?= h($kri->metric) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $kri->hasValue('company') ? $this->Html->link($kri->company->name, ['controller' => 'Companies', 'action' => 'view', $kri->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk') ?></th>
                    <td><?= $kri->hasValue('risk') ? $this->Html->link($kri->risk->title, ['controller' => 'Risks', 'action' => 'view', $kri->risk->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Metric') ?></th>
                    <td><?= h($kri->metric) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($kri->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($kri->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Threshold') ?></th>
                    <td><?= $this->Number->format($kri->threshold) ?></td>
                </tr>
                <tr>
                    <th><?= __('Current Value') ?></th>
                    <td><?= $this->Number->format($kri->current_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($kri->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($kri->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>