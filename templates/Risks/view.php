<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Risk $risk
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Risk'), ['action' => 'edit', $risk->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Risk'), ['action' => 'delete', $risk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $risk->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Risks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Risk'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="risks view content">
            <h3><?= h($risk->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $risk->hasValue('company') ? $this->Html->link($risk->company->name, ['controller' => 'Companies', 'action' => 'view', $risk->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($risk->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($risk->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($risk->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($risk->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Business Unit Id') ?></th>
                    <td><?= $risk->business_unit_id === null ? '' : $this->Number->format($risk->business_unit_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Owner Id') ?></th>
                    <td><?= $risk->owner_id === null ? '' : $this->Number->format($risk->owner_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inherent Risk Score') ?></th>
                    <td><?= $risk->inherent_risk_score === null ? '' : $this->Number->format($risk->inherent_risk_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Residual Risk Score') ?></th>
                    <td><?= $risk->residual_risk_score === null ? '' : $this->Number->format($risk->residual_risk_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($risk->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($risk->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($risk->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Controls') ?></h4>
                <?php if (!empty($risk->controls)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Risk Id') ?></th>
                            <th><?= __('Control Name') ?></th>
                            <th><?= __('Control Type') ?></th>
                            <th><?= __('Frequency') ?></th>
                            <th><?= __('Owner Id') ?></th>
                            <th><?= __('Effectiveness Rating') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($risk->controls as $control) : ?>
                        <tr>
                            <td><?= h($control->id) ?></td>
                            <td><?= h($control->company_id) ?></td>
                            <td><?= h($control->risk_id) ?></td>
                            <td><?= h($control->control_name) ?></td>
                            <td><?= h($control->control_type) ?></td>
                            <td><?= h($control->frequency) ?></td>
                            <td><?= h($control->owner_id) ?></td>
                            <td><?= h($control->effectiveness_rating) ?></td>
                            <td><?= h($control->created) ?></td>
                            <td><?= h($control->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Controls', 'action' => 'view', $control->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Controls', 'action' => 'edit', $control->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Controls', 'action' => 'delete', $control->id], ['confirm' => __('Are you sure you want to delete # {0}?', $control->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Kris') ?></h4>
                <?php if (!empty($risk->kris)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Risk Id') ?></th>
                            <th><?= __('Metric') ?></th>
                            <th><?= __('Threshold') ?></th>
                            <th><?= __('Current Value') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($risk->kris as $kri) : ?>
                        <tr>
                            <td><?= h($kri->id) ?></td>
                            <td><?= h($kri->company_id) ?></td>
                            <td><?= h($kri->risk_id) ?></td>
                            <td><?= h($kri->metric) ?></td>
                            <td><?= h($kri->threshold) ?></td>
                            <td><?= h($kri->current_value) ?></td>
                            <td><?= h($kri->status) ?></td>
                            <td><?= h($kri->created) ?></td>
                            <td><?= h($kri->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Kris', 'action' => 'view', $kri->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Kris', 'action' => 'edit', $kri->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Kris', 'action' => 'delete', $kri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $kri->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Risk Assessments') ?></h4>
                <?php if (!empty($risk->risk_assessments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Risk Id') ?></th>
                            <th><?= __('Likelihood') ?></th>
                            <th><?= __('Impact') ?></th>
                            <th><?= __('Control Effectiveness') ?></th>
                            <th><?= __('Risk Rating') ?></th>
                            <th><?= __('Assessed By') ?></th>
                            <th><?= __('Assessed At') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($risk->risk_assessments as $riskAssessment) : ?>
                        <tr>
                            <td><?= h($riskAssessment->id) ?></td>
                            <td><?= h($riskAssessment->company_id) ?></td>
                            <td><?= h($riskAssessment->risk_id) ?></td>
                            <td><?= h($riskAssessment->likelihood) ?></td>
                            <td><?= h($riskAssessment->impact) ?></td>
                            <td><?= h($riskAssessment->control_effectiveness) ?></td>
                            <td><?= h($riskAssessment->risk_rating) ?></td>
                            <td><?= h($riskAssessment->assessed_by) ?></td>
                            <td><?= h($riskAssessment->assessed_at) ?></td>
                            <td><?= h($riskAssessment->created) ?></td>
                            <td><?= h($riskAssessment->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RiskAssessments', 'action' => 'view', $riskAssessment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RiskAssessments', 'action' => 'edit', $riskAssessment->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RiskAssessments', 'action' => 'delete', $riskAssessment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $riskAssessment->id)]) ?>
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