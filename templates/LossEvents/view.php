<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LossEvent $lossEvent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loss Event'), ['action' => 'edit', $lossEvent->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loss Event'), ['action' => 'delete', $lossEvent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lossEvent->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loss Events'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loss Event'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="lossEvents view content">
            <h3><?= h($lossEvent->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $lossEvent->hasValue('company') ? $this->Html->link($lossEvent->company->name, ['controller' => 'Companies', 'action' => 'view', $lossEvent->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Incident') ?></th>
                    <td><?= $lossEvent->hasValue('incident') ? $this->Html->link($lossEvent->incident->title, ['controller' => 'Incidents', 'action' => 'view', $lossEvent->incident->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($lossEvent->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($lossEvent->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recovery Amount') ?></th>
                    <td><?= $lossEvent->recovery_amount === null ? '' : $this->Number->format($lossEvent->recovery_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Net Loss') ?></th>
                    <td><?= $lossEvent->net_loss === null ? '' : $this->Number->format($lossEvent->net_loss) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($lossEvent->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($lossEvent->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>