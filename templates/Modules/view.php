<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Module'), ['action' => 'edit', $module->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Module'), ['action' => 'delete', $module->id], ['confirm' => __('Are you sure you want to delete # {0}?', $module->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Modules'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Module'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="modules view content">
            <h3><?= h($module->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($module->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($module->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $module->hasValue('company') ? $this->Html->link($module->company->name, ['controller' => 'Companies', 'action' => 'view', $module->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($module->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($module->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($module->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $module->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>