<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evaluation $evaluation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Evaluation'), ['action' => 'edit', $evaluation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Evaluation'), ['action' => 'delete', $evaluation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evaluation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Evaluations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Evaluation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="evaluations view content">
            <h3><?= h($evaluation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tender') ?></th>
                    <td><?= $evaluation->hasValue('tender') ? $this->Html->link($evaluation->tender->title, ['controller' => 'Tenders', 'action' => 'view', $evaluation->tender->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $evaluation->hasValue('user') ? $this->Html->link($evaluation->user->role_id, ['controller' => 'Users', 'action' => 'view', $evaluation->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier') ?></th>
                    <td><?= $evaluation->hasValue('supplier') ? $this->Html->link($evaluation->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $evaluation->supplier->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $evaluation->hasValue('company') ? $this->Html->link($evaluation->company->name, ['controller' => 'Companies', 'action' => 'view', $evaluation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($evaluation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Technical Score') ?></th>
                    <td><?= $this->Number->format($evaluation->technical_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Financial Score') ?></th>
                    <td><?= $this->Number->format($evaluation->financial_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($evaluation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($evaluation->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comments') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($evaluation->comments)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>