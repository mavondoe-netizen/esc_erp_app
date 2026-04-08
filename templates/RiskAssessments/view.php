<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RiskAssessment $riskAssessment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Risk Assessment'), ['action' => 'edit', $riskAssessment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Risk Assessment'), ['action' => 'delete', $riskAssessment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $riskAssessment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Risk Assessments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Risk Assessment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="riskAssessments view content">
            <h3><?= h($riskAssessment->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $riskAssessment->hasValue('company') ? $this->Html->link($riskAssessment->company->name, ['controller' => 'Companies', 'action' => 'view', $riskAssessment->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk') ?></th>
                    <td><?= $riskAssessment->hasValue('risk') ? $this->Html->link($riskAssessment->risk->title, ['controller' => 'Risks', 'action' => 'view', $riskAssessment->risk->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($riskAssessment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Likelihood') ?></th>
                    <td><?= $this->Number->format($riskAssessment->likelihood) ?></td>
                </tr>
                <tr>
                    <th><?= __('Impact') ?></th>
                    <td><?= $this->Number->format($riskAssessment->impact) ?></td>
                </tr>
                <tr>
                    <th><?= __('Control Effectiveness') ?></th>
                    <td><?= $this->Number->format($riskAssessment->control_effectiveness) ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk Rating') ?></th>
                    <td><?= $this->Number->format($riskAssessment->risk_rating) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assessed By') ?></th>
                    <td><?= $riskAssessment->assessed_by === null ? '' : $this->Number->format($riskAssessment->assessed_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assessed At') ?></th>
                    <td><?= h($riskAssessment->assessed_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($riskAssessment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($riskAssessment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>