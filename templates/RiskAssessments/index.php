<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RiskAssessment> $riskAssessments
 */
?>
<div class="riskAssessments index content">
    <?= $this->Html->link(__('New Risk Assessment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Risk Assessments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('risk_id') ?></th>
                    <th><?= $this->Paginator->sort('likelihood') ?></th>
                    <th><?= $this->Paginator->sort('impact') ?></th>
                    <th><?= $this->Paginator->sort('control_effectiveness') ?></th>
                    <th><?= $this->Paginator->sort('risk_rating') ?></th>
                    <th><?= $this->Paginator->sort('assessed_by') ?></th>
                    <th><?= $this->Paginator->sort('assessed_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riskAssessments as $riskAssessment): ?>
                <tr>
                    <td><?= $this->Number->format($riskAssessment->id) ?></td>
                    <td><?= $riskAssessment->hasValue('company') ? $this->Html->link($riskAssessment->company->name, ['controller' => 'Companies', 'action' => 'view', $riskAssessment->company->id]) : '' ?></td>
                    <td><?= $riskAssessment->hasValue('risk') ? $this->Html->link($riskAssessment->risk->title, ['controller' => 'Risks', 'action' => 'view', $riskAssessment->risk->id]) : '' ?></td>
                    <td><?= $this->Number->format($riskAssessment->likelihood) ?></td>
                    <td><?= $this->Number->format($riskAssessment->impact) ?></td>
                    <td><?= $this->Number->format($riskAssessment->control_effectiveness) ?></td>
                    <td><?= $this->Number->format($riskAssessment->risk_rating) ?></td>
                    <td><?= $riskAssessment->assessed_by === null ? '' : $this->Number->format($riskAssessment->assessed_by) ?></td>
                    <td><?= h($riskAssessment->assessed_at) ?></td>
                    <td><?= h($riskAssessment->created) ?></td>
                    <td><?= h($riskAssessment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $riskAssessment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $riskAssessment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $riskAssessment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $riskAssessment->id)]) ?>
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