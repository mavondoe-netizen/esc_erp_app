<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ControlTest $controlTest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Control Test'), ['action' => 'edit', $controlTest->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Control Test'), ['action' => 'delete', $controlTest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controlTest->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Control Tests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Control Test'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="controlTests view content">
            <h3><?= h($controlTest->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $controlTest->hasValue('company') ? $this->Html->link($controlTest->company->name, ['controller' => 'Companies', 'action' => 'view', $controlTest->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Control') ?></th>
                    <td><?= $controlTest->hasValue('control') ? $this->Html->link($controlTest->control->control_name, ['controller' => 'Controls', 'action' => 'view', $controlTest->control->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($controlTest->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tested By') ?></th>
                    <td><?= $controlTest->tested_by === null ? '' : $this->Number->format($controlTest->tested_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tested At') ?></th>
                    <td><?= h($controlTest->tested_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($controlTest->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($controlTest->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Test Result') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($controlTest->test_result)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>