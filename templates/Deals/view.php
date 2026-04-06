<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deal $deal
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if ($deal->status !== 'Approved'): ?>
                <?= $this->Html->link(__('Edit Deal'), ['action' => 'edit', $deal->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Delete Deal'), ['action' => 'delete', $deal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deal->id), 'class' => 'side-nav-item']) ?>
            <?php endif; ?>
            
            <?php if (strpos((string)$deal->status, 'Pending Approval') !== false): ?>
                <hr>
                <?= $this->Form->postLink(__('Approve Deal'), ['action' => 'approve', $deal->id], ['confirm' => __('Are you sure you want to approve this deal?'), 'class' => 'side-nav-item', 'style' => 'color: #27ae60; font-weight: bold;']) ?>
                <?= $this->Form->postLink(__('Reject Deal'), ['action' => 'reject', $deal->id], ['confirm' => __('Are you sure you want to reject this deal?'), 'class' => 'side-nav-item', 'style' => 'color: #e74c3c; font-weight: bold;']) ?>
            <?php elseif ($deal->status === 'Draft' || $deal->status === 'Rejected'): ?>
                <hr>
                <?= $this->Form->postLink(__('Submit for Approval'), ['action' => 'requestForApproval', $deal->id], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>

            <hr>
            <?= $this->Html->link(__('List Deals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Deal'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deals view content">
            <h3><?= h($deal->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($deal->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($deal->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($deal->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stage') ?></th>
                    <td><?= h($deal->stage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact') ?></th>
                    <td><?= $deal->hasValue('contact') ? $this->Html->link($deal->contact->name, ['controller' => 'Contacts', 'action' => 'view', $deal->contact->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($deal->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $deal->hasValue('company') ? $this->Html->link($deal->company->name, ['controller' => 'Companies', 'action' => 'view', $deal->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($deal->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Value') ?></th>
                    <td><?= $this->Number->format($deal->value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Submitted By') ?></th>
                    <td><?= $deal->submitted_by === null ? '' : $this->Number->format($deal->submitted_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $deal->approved_by === null ? '' : $this->Number->format($deal->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rejected By') ?></th>
                    <td><?= $deal->rejected_by === null ? '' : $this->Number->format($deal->rejected_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($deal->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Submitted At') ?></th>
                    <td><?= h($deal->submitted_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved At') ?></th>
                    <td><?= h($deal->approved_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rejected At') ?></th>
                    <td><?= h($deal->rejected_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Rejection Reason') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($deal->rejection_reason)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>