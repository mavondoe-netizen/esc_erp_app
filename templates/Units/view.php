<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Unit $unit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Unit'), ['action' => 'edit', $unit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Unit'), ['action' => 'delete', $unit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Units'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Unit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="units view content">
            <h3><?= h($unit->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($unit->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Building') ?></th>
                    <td><?= $unit->hasValue('building') ? $this->Html->link($unit->building->name, ['controller' => 'Buildings', 'action' => 'view', $unit->building->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($unit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= $this->Number->format($unit->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Vacant') ?></th>
                    <td><?= $unit->isvacant ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Enrolments') ?></h4>
                <?php if (!empty($unit->enrolments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Unit Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Rate') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($unit->enrolments as $enrolment) : ?>
                        <tr>
                            <td><?= h($enrolment->id) ?></td>
                            <td><?= h($enrolment->tenant_id) ?></td>
                            <td><?= h($enrolment->unit_id) ?></td>
                            <td><?= h($enrolment->start_date) ?></td>
                            <td><?= h($enrolment->end_date) ?></td>
                            <td><?= h($enrolment->rate) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Enrolments', 'action' => 'view', $enrolment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Enrolments', 'action' => 'edit', $enrolment->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Enrolments', 'action' => 'delete', $enrolment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enrolment->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>