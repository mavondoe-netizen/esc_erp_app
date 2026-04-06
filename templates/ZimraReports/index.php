<?php
/**
 * @var \App\View\AppView $this
 * @var array $payPeriods
 */
?>
<div class="row">
    <div class="column column-50 column-offset-25">
        <div class="zimraReports form content" style="margin-top: 5rem; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 style="text-align: center; color: #333; margin-bottom: 2rem;">ZIMRA PAYE Tax Return</h3>
            <p style="text-align: center; color: #666; margin-bottom: 2rem;">Select a pay period to generate the aggregated ZIMRA-compliant PAYE tax return report. The data will be mapped according to the system configuration.</p>
            
            <?= $this->Form->create(null, ['url' => ['action' => 'generate']]) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('pay_period_id', [
                        'options' => $payPeriods, 
                        'empty' => 'Select a Pay Period...',
                        'required' => true,
                        'label' => false,
                        'style' => 'font-size: 1.1rem; padding: 0.5rem;'
                    ]);
                ?>
            </fieldset>
            <div style="text-align: center; margin-top: 2rem;">
                <?= $this->Form->button(__('Generate ZIMRA Report'), ['class' => 'button-primary', 'style' => 'font-size: 1.1rem; padding: 0.5rem 2rem;']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
