<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DealRequest> $dealRequests
 */
?>
<div class="dealRequests index content">
    <?= $this->Html->link(__('New Deal Request'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Deal Requests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('first_name', 'Name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('company_name') ?></th>
                    <th><?= $this->Paginator->sort('source') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('deal_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dealRequests as $dealRequest): ?>
                <tr>
                    <td><?= h($dealRequest->first_name) . ' ' . h($dealRequest->last_name) ?></td>
                    <td><?= h($dealRequest->email) ?></td>
                    <td><?= h($dealRequest->phone) ?></td>
                    <td><?= h($dealRequest->company_name) ?></td>
                    <td><?= h($dealRequest->source) ?></td>
                    <td>
                        <?php if ($dealRequest->status === 'New'): ?>
                            <span style="color: blue; font-weight: bold;">NEW</span>
                        <?php elseif ($dealRequest->status === 'Converted'): ?>
                            <span style="color: green; font-weight: bold;">CONVERTED</span>
                        <?php else: ?>
                            <?= h($dealRequest->status) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $dealRequest->hasValue('deal') ? $this->Html->link($dealRequest->deal->name, ['controller' => 'Deals', 'action' => 'view', $dealRequest->deal->id]) : '-' ?></td>
                    <td><?= h($dealRequest->created->timeAgoInWords()) ?></td>
                    <td class="actions">
                        <?php if ($dealRequest->status !== 'Converted'): ?>
                            <?= $this->Form->postLink(__('Convert to Deal'), ['action' => 'convert', $dealRequest->id], ['confirm' => __('Are you sure you want to convert this request into a Deal?'), 'style' => 'color: green; font-weight: bold;']) ?>
                        <?php endif; ?>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $dealRequest->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dealRequest->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dealRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dealRequest->id)]) ?>
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