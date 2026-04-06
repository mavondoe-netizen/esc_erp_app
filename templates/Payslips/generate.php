<div class="row">
    <div class="column column-75">
        <div class="payslips form content">
            <h3>Generate Payslip</h3>
            
            <?= $this->Form->create($payslip) ?>
            
            <?php echo $this->Form->control('pay_period_id', ['options' => $payPeriods]); ?>
            
            <fieldset>
                <legend>Earnings</legend>
                <?php
                echo $this->Form->control('basic_salary', ['default' => $employee->basic_salary, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('allowances', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('bonuses', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('overtime', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('benefits', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                ?>
            
                <legend style="margin-top: 2rem;">Deductions & Statutory</legend>
                <?php
                echo $this->Form->control('pension', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('nssa', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('medical_aid', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                echo $this->Form->control('medical_expenses', ['default' => 0, 'type' => 'number', 'step' => '0.01']);
                ?>
            </fieldset>
            
            <?= $this->Form->button('Generate & Save Payslip') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- Hints Sidebar -->
    <div class="column column-25">
        <div class="content" style="background-color: #f4f6f9; padding: 1.5rem; border-radius: 4px;">
            <h4 style="font-size: 1.2rem; border-bottom: 1px solid #ddd; padding-bottom: 0.5rem;">System Earnings</h4>
            <ul style="font-size: 0.9em; padding-left: 20px; list-style-type: square;">
                <?php foreach ($earnings as $earning): ?>
                    <li><strong><?= h($earning->name) ?></strong> 
                        <br><small style="color: #666;"><?= $earning->taxable ? 'Taxable' : 'Non-Taxable' ?></small>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($earnings)): ?>
                    <li><em>No earnings defined.</em></li>
                <?php endif; ?>
            </ul>

            <h4 style="font-size: 1.2rem; border-bottom: 1px solid #ddd; padding-bottom: 0.5rem; margin-top: 2rem;">System Deductions</h4>
            <ul style="font-size: 0.9em; padding-left: 20px; list-style-type: square;">
                <?php foreach ($deductions as $deduction): ?>
                    <li><strong><?= h($deduction->name) ?></strong> 
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