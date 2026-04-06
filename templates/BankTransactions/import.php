<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="bankTransactions import content" style="max-width: 600px; margin: 40px auto;">
    <div class="card" style="padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white;">
        <h3><i class="fas fa-file-csv"></i> Import Bank Statement</h3>
        <p style="color: #666;">Upload your bank statement in CSV format. We will help you categorize its entries into the system ledger.</p>
        
        <div class="alert alert-info" style="background: #f1f8fa; padding: 15px; border-left: 4px solid #2e6c80; margin-bottom: 25px; font-size: 0.9em;">
            <strong>Expected Columns:</strong><br>
            1. Date (YYYY-MM-DD) - <em>Time component is optional and will be ignored.</em><br>
            2. Description/Narration<br>
            3. Amount (Positive for Credit, Negative for Debit)<br>
            4. Reference (Optional)
            <div style="margin-top: 10px;">
                <?= $this->Html->link(__('Download Sample CSV Template'), ['action' => 'downloadTemplate'], ['class' => 'button button-outline button-small', 'style' => 'font-size: 0.8em; margin-top: 5px;']) ?>
            </div>
        </div>

        <?= $this->Form->create(null, ['type' => 'file']) ?>
        <fieldset style="border: none; padding: 0;">
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; color: #444;">Target Bank Account</label>
                <?= $this->Form->control('bank_account_id', ['options' => $accounts, 'label' => false, 'required' => true, 'empty' => '-- Select Bank Account --']) ?>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; color: #444;">Select CSV File</label>
                <?= $this->Form->control('csv_file', ['type' => 'file', 'label' => false, 'required' => true, 'style' => 'border: 2px dashed #ddd; padding: 20px; width: 100%; border-radius: 8px; text-align: center;']) ?>
            </div>
            
            <div style="margin-bottom: 30px;">
                <label style="font-weight: bold; color: #444;">Currency Mode</label>
                <?= $this->Form->select('currency', ['USD' => 'United States Dollar (USD)', 'ZWG' => 'Zimbabwe Gold (ZWG)'], ['default' => 'USD']) ?>
            </div>
        </fieldset>
        
        <div style="text-align: center;">
            <?= $this->Form->button(__('Upload and Process'), ['class' => 'button', 'style' => 'width: 100%; padding: 12px; font-size: 1.1em;']) ?>
            <div style="margin-top: 15px;">
                <?= $this->Html->link(__('Back to Dashboard'), ['action' => 'index'], ['class' => 'button button-clear']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
