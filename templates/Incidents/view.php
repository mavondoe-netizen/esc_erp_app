<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incident $incident
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Incident'), ['action' => 'edit', $incident->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Incident'), ['action' => 'delete', $incident->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incident->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Incidents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Incident'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="incidents view content">
            <h3><?= h($incident->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $incident->hasValue('company') ? $this->Html->link($incident->company->name, ['controller' => 'Companies', 'action' => 'view', $incident->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($incident->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($incident->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Severity') ?></th>
                    <td><?= h($incident->severity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($incident->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Business Unit Id') ?></th>
                    <td><?= $incident->business_unit_id === null ? '' : $this->Number->format($incident->business_unit_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reported By') ?></th>
                    <td><?= $incident->reported_by === null ? '' : $this->Number->format($incident->reported_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reported At') ?></th>
                    <td><?= h($incident->reported_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($incident->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($incident->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($incident->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Loss Events') ?></h4>
                <?php if (!empty($incident->loss_events)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Incident Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Recovery Amount') ?></th>
                            <th><?= __('Net Loss') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($incident->loss_events as $lossEvent) : ?>
                        <tr>
                            <td><?= h($lossEvent->id) ?></td>
                            <td><?= h($lossEvent->company_id) ?></td>
                            <td><?= h($lossEvent->incident_id) ?></td>
                            <td><?= h($lossEvent->amount) ?></td>
                            <td><?= h($lossEvent->recovery_amount) ?></td>
                            <td><?= h($lossEvent->net_loss) ?></td>
                            <td><?= h($lossEvent->created) ?></td>
                            <td><?= h($lossEvent->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LossEvents', 'action' => 'view', $lossEvent->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LossEvents', 'action' => 'edit', $lossEvent->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LossEvents', 'action' => 'delete', $lossEvent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lossEvent->id)]) ?>
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