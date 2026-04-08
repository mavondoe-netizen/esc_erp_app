<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Levy> $levies
 */
?>
<div class="levies index content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h3><?= __('Levies') ?></h3>
        <?= $this->Html->link(__('+ Add Levy'), ['action' => 'add'], ['class' => 'button']) ?>
    </div>
    <div class="table-responsive">
        <table id="leviesTable">
            <thead>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <th><?= __('Unit') ?></th>
                    <th><?= __('Type') ?></th>
                    <th><?= __('Amount') ?></th>
                    <th><?= __('Due Date') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Paid Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($levies as $levy): ?>
                <tr>
                    <td><?= $levy->hasValue('tenant') ? h($levy->tenant->name) : '–' ?></td>
                    <td><?= $levy->hasValue('unit') ? h($levy->unit->name) : '–' ?></td>
                    <td><?= h($levy->levy_type) ?></td>
                    <td><?= h($levy->currency) ?> <?= number_format((float)$levy->amount, 2) ?></td>
                    <td><?= h($levy->due_date) ?></td>
                    <td>
                        <?php if ($levy->paid): ?>
                            <span style="color:green;font-weight:bold">✓ Paid</span>
                        <?php else: ?>
                            <span style="color:orange;font-weight:bold">⏳ Outstanding</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $levy->paid_date ? h($levy->paid_date) : '–' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $levy->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $levy->id]) ?>
                        <?php if (!$levy->paid): ?>
                            <?= $this->Form->postLink(__('Mark Paid'), ['action' => 'mark_paid', $levy->id], ['confirm' => 'Mark this levy as paid and post to ledger?', 'class' => 'button success']) ?>
                        <?php endif; ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $levy->id], ['confirm' => 'Delete this levy?']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>