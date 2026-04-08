<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientScore $clientScore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Client Scores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="clientScores form content">
            <?= $this->Form->create($clientScore) ?>
            <fieldset>
                <legend><?= __('Add Client Score') ?></legend>
                <?php
                    echo $this->Form->control('client_id');
                    echo $this->Form->control('score');
                    echo $this->Form->control('grade');
                    echo $this->Form->control('risk_level');
                    echo $this->Form->control('debt_ratio');
                    echo $this->Form->control('repayment_history_score');
                    echo $this->Form->control('delinquency_score');
                    echo $this->Form->control('active_loans_count');
                    echo $this->Form->control('computed_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
