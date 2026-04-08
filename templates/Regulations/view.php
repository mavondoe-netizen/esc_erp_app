<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Regulation $regulation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Regulation'), ['action' => 'edit', $regulation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Regulation'), ['action' => 'delete', $regulation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $regulation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Regulations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Regulation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="regulations view content">
            <h3><?= h($regulation->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $regulation->hasValue('company') ? $this->Html->link($regulation->company->name, ['controller' => 'Companies', 'action' => 'view', $regulation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($regulation->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regulator') ?></th>
                    <td><?= h($regulation->regulator) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($regulation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($regulation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($regulation->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($regulation->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Compliance Obligations') ?></h4>
                <?php if (!empty($regulation->compliance_obligations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Regulation Id') ?></th>
                            <th><?= __('Requirement') ?></th>
                            <th><?= __('Frequency') ?></th>
                            <th><?= __('Owner Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($regulation->compliance_obligations as $complianceObligation) : ?>
                        <tr>
                            <td><?= h($complianceObligation->id) ?></td>
                            <td><?= h($complianceObligation->company_id) ?></td>
                            <td><?= h($complianceObligation->regulation_id) ?></td>
                            <td><?= h($complianceObligation->requirement) ?></td>
                            <td><?= h($complianceObligation->frequency) ?></td>
                            <td><?= h($complianceObligation->owner_id) ?></td>
                            <td><?= h($complianceObligation->created) ?></td>
                            <td><?= h($complianceObligation->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ComplianceObligations', 'action' => 'view', $complianceObligation->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ComplianceObligations', 'action' => 'edit', $complianceObligation->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ComplianceObligations', 'action' => 'delete', $complianceObligation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complianceObligation->id)]) ?>
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