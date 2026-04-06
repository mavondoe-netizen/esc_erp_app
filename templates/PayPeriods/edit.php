<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayPeriod $payPeriod
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payPeriod->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payPeriod->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pay Periods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payPeriods form content">
            <?= $this->Form->create($payPeriod) ?>
            <fieldset>
                <legend><?= __('Edit Pay Period') ?></legend>
                <?php
                    $months = [
                        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                    ];
                    $currentMonth = $payPeriod->start_date ? $payPeriod->start_date->format('m') : date('m');
                    $currentYear = $payPeriod->start_date ? $payPeriod->start_date->format('Y') : date('Y');
                    $years = array_combine(range($currentYear - 5, $currentYear + 5), range($currentYear - 5, $currentYear + 5));
                    
                    echo '<div class="row">';
                    echo '<div class="column column-50">' . $this->Form->control('month', ['options' => $months, 'default' => $currentMonth]) . '</div>';
                    echo '<div class="column column-50">' . $this->Form->control('year', ['options' => $years, 'default' => $currentYear]) . '</div>';
                    echo '</div>';
                    
                    echo $this->Form->control('status', ['options' => ['Current' => 'Current (Active)', 'Previous' => 'Previous (Closed)']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
