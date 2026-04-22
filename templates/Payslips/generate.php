<div class="row">
    <div class="column column-75">
        <div class="payslips form content">
            <h3>Bulk Generate Payslips</h3>
            <p>Select a pay period to generate draft payslips for all active employees. Existing payslips for the selected period will be skipped.</p>
            
            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <fieldset>
                <legend><?= __('General Selection') ?></legend>
                <?php 
                echo $this->Form->control('pay_period_id', [
                    'options' => $payPeriods, 
                    'default' => $this->request->getQuery('pay_period_id'),
                    'label' => 'Select Pay Period'
                ]); 
                ?>
            </fieldset>
            
            <div style="margin-top: 20px;">
                <?= $this->Form->button(__('🚀 Start Bulk Generation'), ['class' => 'button']) ?>
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button button-outline', 'style' => 'margin-left: 10px;']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- Hints Sidebar -->
    <div class="column column-25">
        <div class="content" style="background-color: #f4f6f9; padding: 1.5rem; border-radius: 4px;">
            <h4 style="font-size: 1.1rem; border-bottom: 1px solid #ddd; padding-bottom: 0.5rem;">System Earnings</h4>
            <ul style="font-size: 0.85em; padding-left: 15px; list-style-type: square; color: #444;">
                <?php foreach ($earnings as $earning): ?>
                    <li style="margin-bottom: 4px;"><strong><?= h($earning->name) ?></strong> 
                        <br><small style="color: #666;"><?= $earning->taxable ? 'Taxable' : 'Non-Taxable' ?></small>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($earnings)): ?>
                    <li><em>No earnings defined.</em></li>
                <?php endif; ?>
            </ul>

            <h4 style="font-size: 1.1rem; border-bottom: 1px solid #ddd; padding-bottom: 0.5rem; margin-top: 2rem;">System Deductions</h4>
            <ul style="font-size: 0.85em; padding-left: 15px; list-style-type: square; color: #444;">
                <?php foreach ($deductions as $deduction): ?>
                    <li style="margin-bottom: 4px;"><strong><?= h($deduction->name) ?></strong> 
                        <br><small style="color: #666;"><?= $deduction->tax_deductible ? 'Tax Deductible' : 'Not Deductible' ?></small>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($deductions)): ?>
                    <li><em>No deductions defined.</em></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>