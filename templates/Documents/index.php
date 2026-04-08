<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Document> $documents
 */
?>
<div class="documents index content">
    <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Documents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('entity_type') ?></th>
                    <th><?= $this->Paginator->sort('entity_id') ?></th>
                    <th><?= $this->Paginator->sort('file_path') ?></th>
                    <th><?= $this->Paginator->sort('file_name') ?></th>
                    <th><?= $this->Paginator->sort('uploaded_by') ?></th>
                    <th><?= $this->Paginator->sort('uploaded_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?= $this->Number->format($document->id) ?></td>
                    <td><?= $document->hasValue('company') ? $this->Html->link($document->company->name, ['controller' => 'Companies', 'action' => 'view', $document->company->id]) : '' ?></td>
                    <td><?= h($document->entity_type) ?></td>
                    <td><?= $this->Number->format($document->entity_id) ?></td>
                    <td><?= h($document->file_path) ?></td>
                    <td><?= h($document->file_name) ?></td>
                    <td><?= $document->uploaded_by === null ? '' : $this->Number->format($document->uploaded_by) ?></td>
                    <td><?= h($document->uploaded_at) ?></td>
                    <td><?= h($document->created) ?></td>
                    <td><?= h($document->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
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