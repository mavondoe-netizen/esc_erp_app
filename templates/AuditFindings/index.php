<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditFinding> $auditFindings
 */
?>
<div class="auditFindings index content">
    <?= $this->Html->link(__('New Audit Finding'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Findings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('audit_id') ?></th>
                    <th><?= $this->Paginator->sort('risk_level') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditFindings as $auditFinding): ?>
                <tr>
                    <td><?= $this->Number->format($auditFinding->id) ?></td>
                    <td><?= $auditFinding->hasValue('company') ? $this->Html->link($auditFinding->company->name, ['controller' => 'Companies', 'action' => 'view', $auditFinding->company->id]) : '' ?></td>
                    <td><?= $auditFinding->hasValue('audit') ? $this->Html->link($auditFinding->audit->title, ['controller' => 'Audits', 'action' => 'view', $auditFinding->audit->id]) : '' ?></td>
                    <td><?= h($auditFinding->risk_level) ?></td>
                    <td><?= h($auditFinding->status) ?></td>
                    <td><?= h($auditFinding->created) ?></td>
                    <td><?= h($auditFinding->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditFinding->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditFinding->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auditFinding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditFinding->id)]) ?>
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