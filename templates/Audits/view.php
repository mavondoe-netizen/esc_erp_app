<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Audit $audit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit'), ['action' => 'edit', $audit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit'), ['action' => 'delete', $audit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="audits view content">
            <h3><?= h($audit->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $audit->hasValue('company') ? $this->Html->link($audit->company->name, ['controller' => 'Companies', 'action' => 'view', $audit->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Audit Plan') ?></th>
                    <td><?= $audit->hasValue('audit_plan') ? $this->Html->link($audit->audit_plan->audit_type, ['controller' => 'AuditPlans', 'action' => 'view', $audit->audit_plan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($audit->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($audit->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($audit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auditor Id') ?></th>
                    <td><?= $audit->auditor_id === null ? '' : $this->Number->format($audit->auditor_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($audit->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($audit->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Scope') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($audit->scope)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Audit Findings') ?></h4>
                <?php if (!empty($audit->audit_findings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Audit Id') ?></th>
                            <th><?= __('Finding') ?></th>
                            <th><?= __('Risk Level') ?></th>
                            <th><?= __('Root Cause') ?></th>
                            <th><?= __('Recommendation') ?></th>
                            <th><?= __('Management Response') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($audit->audit_findings as $auditFinding) : ?>
                        <tr>
                            <td><?= h($auditFinding->id) ?></td>
                            <td><?= h($auditFinding->company_id) ?></td>
                            <td><?= h($auditFinding->audit_id) ?></td>
                            <td><?= h($auditFinding->finding) ?></td>
                            <td><?= h($auditFinding->risk_level) ?></td>
                            <td><?= h($auditFinding->root_cause) ?></td>
                            <td><?= h($auditFinding->recommendation) ?></td>
                            <td><?= h($auditFinding->management_response) ?></td>
                            <td><?= h($auditFinding->status) ?></td>
                            <td><?= h($auditFinding->created) ?></td>
                            <td><?= h($auditFinding->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AuditFindings', 'action' => 'view', $auditFinding->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AuditFindings', 'action' => 'edit', $auditFinding->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AuditFindings', 'action' => 'delete', $auditFinding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditFinding->id)]) ?>
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