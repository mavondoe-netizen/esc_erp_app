<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enrolment $enrolment
 * @var iterable $payments
 * @var iterable $levies
 */
$statusColor = ['Active' => 'green', 'Terminated' => 'red', 'Expired' => 'orange'][$enrolment->status] ?? 'gray';
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Lease'), ['action' => 'edit', $enrolment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Record Payment'), ['controller' => 'LeasePayments', 'action' => 'add', '?' => ['enrolment_id' => $enrolment->id]], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Add Levy'), ['controller' => 'Levies', 'action' => 'add', '?' => ['enrolment_id' => $enrolment->id]], ['class' => 'side-nav-item']) ?>
            <?php if ($enrolment->status === 'Active'): ?>
                <?= $this->Form->postLink(
                    __('⛔ Terminate Lease'),
                    ['action' => 'terminate', $enrolment->id],
                    ['confirm' => 'Are you sure you want to terminate this lease? This cannot be undone.', 'class' => 'side-nav-item', 'style' => 'color:red']
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Leases'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="enrolments view content">
            <h3>
                Lease #<?= $enrolment->id ?>
                <span style="font-size:0.75rem;color:<?= $statusColor ?>;border:1px solid <?= $statusColor ?>;padding:2px 8px;border-radius:12px;margin-left:8px">
                    <?= h($enrolment->status) ?>
                </span>
            </h3>

            <table>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $enrolment->hasValue('tenant') ? h($enrolment->tenant->name) : '–' ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= $enrolment->hasValue('unit') ? h($enrolment->unit->name) : '–' ?></td>
                </tr>
                <?php if ($enrolment->hasValue('unit') && $enrolment->unit->hasValue('building')): ?>
                <tr>
                    <th><?= __('Building') ?></th>
                    <td><?= h($enrolment->unit->building->name) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <th><?= __('Monthly Rate') ?></th>
                    <td><strong><?= number_format((float)$enrolment->rate, 2) ?></strong></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($enrolment->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= $enrolment->end_date ? h($enrolment->end_date) : '<em>Ongoing</em>' ?></td>
                </tr>
            </table>

            <!-- Related Payments -->
            <div class="related" style="margin-top:2rem">
                <h4><?= __('Rental Payments') ?></h4>
                <?php $paymentsList = is_iterable($payments) ? $payments : []; $hasPayments = false; foreach($paymentsList as $_check){ $hasPayments = true; break; } ?>
                <?php if ($hasPayments): ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Period') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Mode') ?></th>
                            <th><?= __('Reference') ?></th>
                            <th><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($payments as $p): ?>
                        <tr>
                            <td><?= h($p->date) ?></td>
                            <td><?= h($p->period_covered) ?></td>
                            <td><?= h($p->currency) ?> <?= number_format((float)$p->amount, 2) ?></td>
                            <td><?= h($p->payment_mode) ?></td>
                            <td><?= h($p->reference) ?></td>
                            <td><?= $this->Html->link('View', ['controller' => 'LeasePayments', 'action' => 'view', $p->id]) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php else: ?>
                    <p><em>No payments recorded yet.</em></p>
                <?php endif; ?>
            </div>

            <!-- Related Levies -->
            <div class="related" style="margin-top:2rem">
                <h4><?= __('Levies') ?></h4>
                <?php $leviesList = is_iterable($levies) ? $levies : []; $hasLevies = false; foreach($leviesList as $_chk){ $hasLevies = true; break; } ?>
                <?php if ($hasLevies): ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Status') ?></th>
                        </tr>
                        <?php foreach ($levies as $l): ?>
                        <tr>
                            <td><?= h($l->levy_type) ?></td>
                            <td><?= h($l->currency) ?> <?= number_format((float)$l->amount, 2) ?></td>
                            <td><?= h($l->due_date) ?></td>
                            <td style="color:<?= $l->paid ? 'green' : 'orange' ?>;font-weight:bold">
                                <?= $l->paid ? '✓ Paid' : '⏳ Outstanding' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php else: ?>
                    <p><em>No levies charged yet.</em></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>