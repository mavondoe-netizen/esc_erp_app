<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditPlan $auditPlan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Plan'), ['action' => 'edit', $auditPlan->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Plan'), ['action' => 'delete', $auditPlan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditPlan->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Plans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Plan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditPlans view content">
            <h3><?= h($auditPlan->audit_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $auditPlan->hasValue('company') ? $this->Html->link($auditPlan->company->name, ['controller' => 'Companies', 'action' => 'view', $auditPlan->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Audit Type') ?></th>
                    <td><?= h($auditPlan->audit_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditPlan->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $this->Number->format($auditPlan->year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Business Unit Id') ?></th>
                    <td><?= $auditPlan->business_unit_id === null ? '' : $this->Number->format($auditPlan->business_unit_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Planned Start') ?></th>
                    <td><?= h($auditPlan->planned_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Planned End') ?></th>
                    <td><?= h($auditPlan->planned_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auditPlan->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($auditPlan->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Audits') ?></h4>
                <?php if (!empty($auditPlan->audits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Audit Plan Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Scope') ?></th>
                            <th><?= __('Auditor Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($auditPlan->audits as $audit) : ?>
                        <tr>
                            <td><?= h($audit->id) ?></td>
                            <td><?= h($audit->company_id) ?></td>
                            <td><?= h($audit->audit_plan_id) ?></td>
                            <td><?= h($audit->title) ?></td>
                            <td><?= h($audit->scope) ?></td>
                            <td><?= h($audit->auditor_id) ?></td>
                            <td><?= h($audit->status) ?></td>
                            <td><?= h($audit->created) ?></td>
                            <td><?= h($audit->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Audits', 'action' => 'view', $audit->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Audits', 'action' => 'edit', $audit->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Audits', 'action' => 'delete', $audit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->id)]) ?>
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