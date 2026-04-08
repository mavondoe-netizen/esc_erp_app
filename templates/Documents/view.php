<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Documents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documents view content">
            <h3><?= h($document->entity_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $document->hasValue('company') ? $this->Html->link($document->company->name, ['controller' => 'Companies', 'action' => 'view', $document->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Type') ?></th>
                    <td><?= h($document->entity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Path') ?></th>
                    <td><?= h($document->file_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('File Name') ?></th>
                    <td><?= h($document->file_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($document->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Id') ?></th>
                    <td><?= $this->Number->format($document->entity_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uploaded By') ?></th>
                    <td><?= $document->uploaded_by === null ? '' : $this->Number->format($document->uploaded_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uploaded At') ?></th>
                    <td><?= h($document->uploaded_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($document->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($document->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>