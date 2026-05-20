<?php
/**
 * @var \App\View\AppView $this
 * @var array $deals
 */
$this->assign('title', 'Deal Pipeline');
?>
<div class="row">
    <div class="column">
        <div class="deals index content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3><?= __('Deal Pipeline') ?></h3>
                <div>
                    <?= $this->Html->link(__('List Deals'), ['action' => 'index'], ['class' => 'button button-outline']) ?>
                    <?= $this->Html->link(__('Analytics'), ['action' => 'analytics'], ['class' => 'button button-outline']) ?>
                    <?= $this->Html->link(__('New Deal'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </div>

            <div style="display: flex; gap: 15px; overflow-x: auto; padding-bottom: 20px;">
                <?php foreach (['Lead', 'Qualified', 'Proposal', 'Negotiation', 'Closed Won', 'Closed Lost'] as $stage): ?>
                    <div style="flex: 0 0 300px; background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #e1e4e8;">
                        <h4 style="margin-top:0; border-bottom: 2px solid #0056b3; padding-bottom: 10px;"><?= h($stage) ?> <span style="float: right; font-size: 0.8em; color: #666; background: #e1e4e8; padding: 2px 8px; border-radius: 12px;"><?= count($deals[$stage]) ?></span></h4>
                        
                        <div style="display: flex; flex-direction: column; gap: 10px; min-height: 200px;">
                            <?php foreach ($deals[$stage] as $deal): ?>
                                <div style="background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                    <div style="font-weight: bold; margin-bottom: 5px;">
                                        <?= $this->Html->link($deal->name, ['action' => 'view', $deal->id]) ?>
                                    </div>
                                    <div style="font-size: 0.9em; color: #555; margin-bottom: 8px;">
                                        <?= $deal->hasValue('contact') ? h($deal->contact->name) : 'No Contact' ?>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9em;">
                                        <span style="font-weight: bold; color: #27ae60;">$<?= $this->Number->format($deal->value) ?></span>
                                        <span style="background: #eef2f5; padding: 2px 6px; border-radius: 4px; font-size: 0.8em;"><?= h($deal->type) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
