<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Control $control
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Control'), ['action' => 'edit', $control->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Control'), ['action' => 'delete', $control->id], ['confirm' => __('Are you sure you want to delete # {0}?', $control->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Controls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Control'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="controls view content">
            <h3><?= h($control->control_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $control->hasValue('company') ? $this->Html->link($control->company->name, ['controller' => 'Companies', 'action' => 'view', $control->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk') ?></th>
                    <td><?= $control->hasValue('risk') ? $this->Html->link($control->risk->title, ['controller' => 'Risks', 'action' => 'view', $control->risk->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Control Name') ?></th>
                    <td><?= h($control->control_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Control Type') ?></th>
                    <td><?= h($control->control_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Frequency') ?></th>
                    <td><?= h($control->frequency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Effectiveness Rating') ?></th>
                    <td><?= h($control->effectiveness_rating) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($control->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Owner Id') ?></th>
                    <td><?= $control->owner_id === null ? '' : $this->Number->format($control->owner_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($control->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($control->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Control Tests') ?></h4>
                <?php if (!empty($control->control_tests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Control Id') ?></th>
                            <th><?= __('Test Result') ?></th>
                            <th><?= __('Tested By') ?></th>
                            <th><?= __('Tested At') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($control->control_tests as $controlTest) : ?>
                        <tr>
                            <td><?= h($controlTest->id) ?></td>
                            <td><?= h($controlTest->company_id) ?></td>
                            <td><?= h($controlTest->control_id) ?></td>
                            <td><?= h($controlTest->test_result) ?></td>
                            <td><?= h($controlTest->tested_by) ?></td>
                            <td><?= h($controlTest->tested_at) ?></td>
                            <td><?= h($controlTest->created) ?></td>
                            <td><?= h($controlTest->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ControlTests', 'action' => 'view', $controlTest->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ControlTests', 'action' => 'edit', $controlTest->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ControlTests', 'action' => 'delete', $controlTest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlTest->id)]) ?>
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