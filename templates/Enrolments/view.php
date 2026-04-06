<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enrolment $enrolment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Enrolment'), ['action' => 'edit', $enrolment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Enrolment'), ['action' => 'delete', $enrolment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrolment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Enrolments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Enrolment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="enrolments view content">
            <h3><?= h($enrolment->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= $enrolment->hasValue('unit') ? $this->Html->link($enrolment->unit->name, ['controller' => 'Units', 'action' => 'view', $enrolment->unit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($enrolment->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($enrolment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant Id') ?></th>
                    <td><?= $this->Number->format($enrolment->tenant_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rate') ?></th>
                    <td><?= $this->Number->format($enrolment->rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($enrolment->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($enrolment->end_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>