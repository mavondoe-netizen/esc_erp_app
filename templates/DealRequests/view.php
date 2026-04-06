<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DealRequest $dealRequest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if ($dealRequest->status !== 'Converted'): ?>
                <?= $this->Form->postLink(__('Convert to Deal'), ['action' => 'convert', $dealRequest->id], ['confirm' => __('Are you sure you want to convert this request into a Deal?'), 'class' => 'side-nav-item', 'style' => 'color: green; font-weight: bold;']) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('Edit Deal Request'), ['action' => 'edit', $dealRequest->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Deal Request'), ['action' => 'delete', $dealRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dealRequest->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Deal Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Deal Request'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dealRequests view content">
            <h3><?= h($dealRequest->first_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($dealRequest->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($dealRequest->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($dealRequest->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($dealRequest->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Name') ?></th>
                    <td><?= h($dealRequest->company_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Source') ?></th>
                    <td><?= h($dealRequest->source) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
                        <?php if ($dealRequest->status === 'New'): ?>
                            <span style="color: blue; font-weight: bold;">NEW</span>
                        <?php elseif ($dealRequest->status === 'Converted'): ?>
                            <span style="color: green; font-weight: bold;">CONVERTED</span>
                        <?php else: ?>
                            <?= h($dealRequest->status) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $dealRequest->hasValue('company') ? $this->Html->link($dealRequest->company->name, ['controller' => 'Companies', 'action' => 'view', $dealRequest->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Deal') ?></th>
                    <td><?= $dealRequest->hasValue('deal') ? $this->Html->link($dealRequest->deal->name, ['controller' => 'Deals', 'action' => 'view', $dealRequest->deal->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($dealRequest->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($dealRequest->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($dealRequest->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($dealRequest->message)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>