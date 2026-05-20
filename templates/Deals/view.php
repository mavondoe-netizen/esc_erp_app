<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deal $deal
 * @var \App\Model\Entity\Approval|null $approval
 * @var array $approvalHistory
 * @var array $approvalLevels
 * @var bool $canAct
 */

$statusColors = [
    'Draft'            => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],
    'Pending Approval' => ['bg' => '#fef9c3', 'text' => '#92400e', 'border' => '#fde047'],
    'Approved'         => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
    'Rejected'         => ['bg' => '#fee2e2', 'text' => '#991b1b', 'border' => '#fca5a5'],
];
$sc = $statusColors[$deal->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'];
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if (in_array($deal->status, ['Draft', 'Rejected', 'Active'])): ?>
                <?= $this->Html->link(__('Edit Deal'), ['action' => 'edit', $deal->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Delete Deal'), ['action' => 'delete', $deal->id], ['confirm' => __('Are you sure?'), 'class' => 'side-nav-item']) ?>
                <hr>
                <?= $this->Form->postLink(__('Submit for Approval'), ['action' => 'requestForApproval', $deal->id], ['class' => 'side-nav-item', 'style' => 'color: var(--primary-color); font-weight: bold;']) ?>
            <?php elseif ($deal->status === 'Pending Approval'): ?>
                <?= $this->Html->link(__('Edit Deal'), ['action' => 'edit', $deal->id], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
            <hr>
            <?= $this->Html->link(__('List Deals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Deal'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="deals view content">

            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px;">
                <div>
                    <h2 style="margin: 0 0 6px 0; color: #0f172a;"><?= h($deal->name) ?></h2>
                    <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">
                        Deal #<?= h($deal->id) ?> &bull; <?= h($deal->date) ?>
                    </span>
                </div>
                <span style="background: <?= $sc['bg'] ?>; color: <?= $sc['text'] ?>; border: 1px solid <?= $sc['border'] ?>; padding: 7px 20px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.03em;">
                    <?= strtoupper(h($deal->status)) ?>
                </span>
            </div>

            <!-- Core Info Cards -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 24px;">
                <div style="background: linear-gradient(135deg, var(--primary-color), #6366f1); border-radius: 12px; padding: 22px; color: #fff;">
                    <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.07em; opacity: 0.8; margin-bottom: 6px;">Deal Value</div>
                    <div style="font-size: 2rem; font-weight: 800;"><?= $this->Number->currency($deal->value, 'USD') ?></div>
                </div>
                <div style="background: #f8fafc; border-radius: 12px; padding: 22px;">
                    <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 6px;">Type</div>
                    <div style="font-size: 1.1rem; font-weight: 600; color: #0f172a;"><?= h($deal->type ?: '—') ?></div>
                </div>
                <div style="background: #f8fafc; border-radius: 12px; padding: 22px;">
                    <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 6px;">Stage</div>
                    <div style="font-size: 1.1rem; font-weight: 600; color: #0f172a;"><?= h($deal->stage ?: '—') ?></div>
                </div>
            </div>

            <!-- Description & Contact -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px;">
                    <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 10px;">Description</div>
                    <p style="color: #334155; line-height: 1.7; margin: 0;"><?= nl2br(h($deal->description ?: '—')) ?></p>
                </div>
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px;">
                    <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 10px;">Contact</div>
                    <div style="font-size: 1rem; font-weight: 600; color: #0f172a;">
                        <?= $deal->hasValue('contact') ? $this->Html->link($deal->contact->name, ['controller' => 'Contacts', 'action' => 'view', $deal->contact->id]) : '—' ?>
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!--  APPROVAL WORKFLOW PANEL                                      -->
            <!-- ============================================================ -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 24px;">

                <!-- Panel Header -->
                <div style="background: #0f172a; color: #fff; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 700; font-size: 0.9rem; letter-spacing: 0.04em;">
                        <i class="fa fa-check-circle" style="margin-right: 8px;"></i>APPROVAL WORKFLOW
                    </span>
                    <?php if ($approval): ?>
                        <?php
                            $aStatus = strtolower($approval->status);
                            $pill = match(true) {
                                $aStatus === 'approved' => ['bg' => '#dcfce7', 'text' => '#166534', 'label' => 'APPROVED'],
                                $aStatus === 'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'REJECTED'],
                                default                 => ['bg' => '#fef9c3', 'text' => '#92400e', 'label' => 'PENDING LEVEL ' . $approval->current_level],
                            };
                        ?>
                        <span style="background: <?= $pill['bg'] ?>; color: <?= $pill['text'] ?>; padding: 4px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                            <?= $pill['label'] ?>
                        </span>
                    <?php else: ?>
                        <span style="background: #334155; color: #94a3b8; padding: 4px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">NOT SUBMITTED</span>
                    <?php endif; ?>
                </div>

                <div style="padding: 24px;">

                    <!-- Approval Level Progress -->
                    <?php if (!empty($approvalLevels)): ?>
                    <div style="margin-bottom: 24px;">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;">Approval Chain</div>
                        <div style="display: flex; gap: 0; align-items: center;">
                            <?php foreach ($approvalLevels as $i => $lvl): ?>
                                <?php
                                    $levelDone     = false;
                                    $levelCurrent  = false;
                                    $levelPending  = true;
                                    if ($approval) {
                                        if (strtolower($approval->status) === 'approved') {
                                            $levelDone = true; // all done
                                        } elseif ($approval->current_level > $lvl->level) {
                                            $levelDone = true;
                                        } elseif ($approval->current_level == $lvl->level) {
                                            $levelCurrent = true;
                                        }
                                    }
                                    $circleBg   = $levelDone ? '#16a34a' : ($levelCurrent ? 'var(--primary-color)' : '#e2e8f0');
                                    $circleText = $levelDone ? '#fff' : ($levelCurrent ? '#fff' : '#94a3b8');
                                    $labelText  = $levelDone ? '#16a34a' : ($levelCurrent ? 'var(--primary-color)' : '#94a3b8');
                                ?>
                                <?php if ($i > 0): ?>
                                    <div style="flex: 1; height: 2px; background: <?= $levelDone || $levelCurrent ? 'var(--primary-color)' : '#e2e8f0' ?>;"></div>
                                <?php endif; ?>
                                <div style="text-align: center; min-width: 90px;">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: <?= $circleBg ?>; color: <?= $circleText ?>; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; margin: 0 auto 6px; border: 2px solid <?= $levelCurrent ? 'var(--primary-color)' : 'transparent' ?>;">
                                        <?php if ($levelDone): ?>
                                            <i class="fa fa-check"></i>
                                        <?php else: ?>
                                            <?= $lvl->level ?>
                                        <?php endif; ?>
                                    </div>
                                    <div style="font-size: 0.7rem; color: <?= $labelText ?>; font-weight: 600; line-height: 1.3;">
                                        <?= h($lvl->role->name ?? 'Level ' . $lvl->level) ?>
                                        <?php if ($lvl->min_value > 0): ?>
                                            <br><span style="font-weight: 400;">&gt; <?= $this->Number->currency($lvl->min_value, 'USD') ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Approve / Reject Action Forms -->
                    <?php if ($canAct && $approval): ?>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                        <div style="font-size: 0.8rem; color: #475569; font-weight: 600; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 0.04em;">
                            <i class="fa fa-gavel" style="margin-right: 6px; color: var(--primary-color);"></i>Your Decision — Level <?= h($approval->current_level) ?>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">

                            <!-- Approve Form -->
                            <?= $this->Form->create(null, ['url' => ['action' => 'approveApproval', $approval->id], 'style' => 'margin: 0;']) ?>
                                <div>
                                    <label style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 5px;">Remarks (optional)</label>
                                    <input type="text" name="remarks" class="form-control" placeholder="Add approval remarks..." style="margin-bottom: 10px;">
                                    <button type="submit" class="button" style="background: #16a34a; color: #fff; border: none; width: 100%; padding: 10px; font-weight: 700; border-radius: 8px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Approve this deal at level <?= h($approval->current_level) ?>?')">
                                        <i class="fa fa-check" style="margin-right: 6px;"></i> Approve
                                    </button>
                                </div>
                            <?= $this->Form->end() ?>

                            <!-- Reject Form -->
                            <?= $this->Form->create(null, ['url' => ['action' => 'rejectApproval', $approval->id], 'style' => 'margin: 0;']) ?>
                                <div>
                                    <label style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 5px;">Rejection Reason</label>
                                    <input type="text" name="remarks" class="form-control" placeholder="Provide a reason for rejection..." style="margin-bottom: 10px;" required>
                                    <button type="submit" class="button" style="background: #dc2626; color: #fff; border: none; width: 100%; padding: 10px; font-weight: 700; border-radius: 8px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Reject this deal?')">
                                        <i class="fa fa-times" style="margin-right: 6px;"></i> Reject
                                    </button>
                                </div>
                            <?= $this->Form->end() ?>

                        </div>
                    </div>
                    <?php elseif ($approval && strtolower($approval->status) === 'pending'): ?>
                    <div style="background: #fef9c3; border: 1px solid #fde047; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; font-size: 0.85rem; color: #92400e;">
                        <i class="fa fa-clock-o" style="margin-right: 8px;"></i>
                        Awaiting approval from the <strong>Level <?= h($approval->current_level) ?></strong> approver. You do not have permission to act on this level.
                    </div>
                    <?php endif; ?>

                    <!-- Approval History Trail -->
                    <?php if (!empty($approvalHistory)): ?>
                    <div>
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">Approval History</div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <?php foreach ($approvalHistory as $hist): ?>
                                <?php
                                    $hColor = match(strtolower($hist->action)) {
                                        'approved'  => '#16a34a',
                                        'rejected'  => '#dc2626',
                                        'initiated', 'initiated' => '#6366f1',
                                        default     => '#64748b',
                                    };
                                    $hIcon = match(strtolower($hist->action)) {
                                        'approved'  => 'check',
                                        'rejected'  => 'times',
                                        'initiated' => 'play',
                                        default     => 'circle-o',
                                    };
                                ?>
                                <div style="display: flex; align-items: flex-start; gap: 12px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; border-left: 3px solid <?= $hColor ?>;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: <?= $hColor ?>; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.75rem;">
                                        <i class="fa fa-<?= $hIcon ?>"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                            <span style="font-weight: 700; font-size: 0.85rem; color: <?= $hColor ?>;"><?= strtoupper(h($hist->action)) ?></span>
                                            <?php if ($hist->level): ?>
                                                <span style="font-size: 0.72rem; background: #e2e8f0; color: #475569; padding: 2px 8px; border-radius: 10px;">Level <?= h($hist->level) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($hist->remarks): ?>
                                            <div style="font-size: 0.82rem; color: #334155; margin-top: 2px;"><?= h($hist->remarks) ?></div>
                                        <?php endif; ?>
                                        <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 4px;"><?= h($hist->created) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php elseif (!$approval): ?>
                    <div style="text-align: center; padding: 30px; color: #94a3b8;">
                        <i class="fa fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        This deal has not been submitted for approval yet.<br>
                        <?php if (in_array($deal->status, ['Draft', 'Active', 'Rejected'])): ?>
                            <small>Use <strong>Submit for Approval</strong> in the sidebar to start the process.</small>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <!-- END APPROVAL PANEL -->

        </div>
    </div>
</div>