<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 * @var string[]|\Cake\Collection\CollectionInterface $employees
 * @var string[]|\Cake\Collection\CollectionInterface $payPeriods
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payslip->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Payslips'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payslips form content">
            <?= $this->Form->create($payslip, ['id' => 'payslip-form']) ?>
            <fieldset>
                <legend><?= __('Edit Payslip') ?></legend>
                
                <div class="row">
                    <div class="column column-33">
                        <div style="display: flex; align-items: flex-end; gap: 8px;">
                            <div style="flex-grow: 1;">
                                <?= $this->Form->control('employee_id', ['options' => $employees, 'empty' => 'Select Employee', 'id' => 'employee-select', 'class' => 'form-control']) ?>
                            </div>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/employees/add?popup=1" data-target-dropdown="employee-select" style="margin-bottom: 1.5rem; padding: 0.65rem 0.8rem;" title="Add New Employee">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="column column-33">
                        <div style="display: flex; align-items: flex-end; gap: 8px;">
                            <div style="flex-grow: 1;">
                                <?= $this->Form->control('pay_period_id', ['options' => $payPeriods, 'id' => 'pay-period-id', 'class' => 'form-control']) ?>
                            </div>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/pay-periods/add?popup=1" data-target-dropdown="pay-period-id" style="margin-bottom: 1.5rem; padding: 0.65rem 0.8rem;" title="Add New Pay Period">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="column column-33">
                        <?= $this->Form->control('generated_date', ['type' => 'date', 'class' => 'form-control']) ?>
                    </div>
                </div>
                
                <div class="row" style="margin-bottom: 20px;">
                    <div class="column column-33">
                        <?= $this->Form->control('exchange_rate', ['type' => 'number', 'step' => '0.0001', 'id' => 'exchange-rate', 'class' => 'form-control']) ?>
                    </div>
                </div>

                <h4 style="margin-top: 2rem; border-bottom: 2px solid #eee; padding-bottom: 10px;">Payslip Components</h4>
                
                <table style="width: 100%; margin-bottom: 10px;" id="components-table">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="width: 15%;">Type</th>
                            <th style="width: 30%;">Description</th>
                            <th style="width: 15%;">Currency</th>
                            <th style="width: 20%;">Amount</th>
                            <th style="width: 10%; text-align: right;">Perm?</th>
                            <th style="width: 10%; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="items-container">
                        <!-- JS injected rows -->
                    </tbody>
                </table>
                
                <div style="display: flex; gap: 10px; margin-bottom: 2rem;">
                    <button type="button" class="button button-outline" onclick="addRow('Earning')"><i class="fa fa-plus"></i> Add Earning</button>
                    <button type="button" class="button button-outline" onclick="addRow('Deduction')"><i class="fa fa-minus"></i> Add Deduction</button>
                    <button type="button" class="button" onclick="calculateTaxes()" style="margin-left: auto; background-color: #900000; border-color: #900000;">
                        <i class="fa fa-calculator"></i> Calculate Taxes
                    </button>
                </div>

                <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h5 style="margin-bottom: 15px;">Calculated Totals</h5>
                    <div class="row">
                        <div class="column">
                            <label>USD Gross</label>
                            <?= $this->Form->text('usd_gross', ['id' => 'usd_gross', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold;']) ?>
                        </div>
                        <div class="column">
                            <label>USD Deductions</label>
                            <?= $this->Form->text('usd_deductions', ['id' => 'usd_deductions', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #900000;']) ?>
                        </div>
                        <div class="column">
                            <label>USD Net</label>
                            <?= $this->Form->text('usd_net', ['id' => 'usd_net', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #2e6c80; font-size: 1.2rem;']) ?>
                        </div>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="row">
                        <div class="column">
                            <label>ZWG Gross</label>
                            <?= $this->Form->text('zwg_gross', ['id' => 'zwg_gross', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold;']) ?>
                        </div>
                        <div class="column">
                            <label>ZWG Deductions</label>
                            <?= $this->Form->text('zwg_deductions', ['id' => 'zwg_deductions', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #900000;']) ?>
                        </div>
                        <div class="column">
                            <label>ZWG Net</label>
                            <?= $this->Form->text('zwg_net', ['id' => 'zwg_net', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #9b4dca; font-size: 1.2rem;']) ?>
                        </div>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="row" style="background: #e0e7ff; padding: 10px; border-radius: 4px; margin-top: 10px;">
                        <div class="column">
                            <label>Equiv Gross (USD)</label>
                            <?= $this->Form->text('gross_pay', ['id' => 'gross_pay', 'readonly' => true, 'style' => 'background: transparent; border: none;']) ?>
                        </div>
                        <div class="column">
                            <label>Equiv Deductions (USD)</label>
                            <?= $this->Form->text('deductions', ['id' => 'total_deductions', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #900000;']) ?>
                        </div>
                        <div class="column">
                            <label>Equiv Net Pay (USD)</label>
                            <?= $this->Form->text('net_pay', ['id' => 'net_pay', 'readonly' => true, 'style' => 'background: transparent; border: none; font-weight: bold; color: #0f172a; font-size: 1.4rem;']) ?>
                        </div>
                    </div>
                </div>

            </fieldset>
            <div style="margin-top: 2rem;">
                <?= $this->Form->button(__('Save Payslip')) ?> 
                <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<datalist id="earnings-list">
    <?php foreach ($systemEarnings as $earning): ?>
        <option value="<?= h($earning) ?>">
    <?php endforeach; ?>
</datalist>

<datalist id="deductions-list">
    <?php foreach ($systemDeductions as $deduction): ?>
        <option value="<?= h($deduction) ?>">
    <?php endforeach; ?>
</datalist>

<script>
    let rowIndex = 0;
    const csrfToken = '<?= $this->request->getAttribute("csrfToken") ?>';
    const earningsMeta = <?= json_encode($earningsMetadata ?? []) ?>;
    const existingItems = <?= json_encode($payslip->payslip_items ?: []) ?>;

    function addRow(type = 'Earning', defaultData = null) {
        const container = document.getElementById('items-container');
        const tr = document.createElement('tr');
        
        const isTax = type === 'Tax' || type === 'Company Contribution';
        const trClass = isTax ? 'tax-row' : 'manual-row';
        tr.className = trClass;
        tr.id = `row-${rowIndex}`;

        const idValue = defaultData && defaultData.id ? defaultData.id : '';
        const nameValue = defaultData ? defaultData.name : '';
        const currValue = defaultData ? defaultData.currency : 'USD';
        const amtValue = defaultData ? defaultData.amount : '0.00';
        const isPermanent = defaultData ? (defaultData.is_permanent ? '1' : '0') : '0';
        
        let badgesHtml = '';
        if (type === 'Earning' && nameValue && earningsMeta[nameValue]) {
            if (earningsMeta[nameValue].is_gross_up) {
                badgesHtml += ` <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 0.7rem; padding: 2px 4px; border-radius: 4px; display: inline-block; margin-top: 2px;">Gross-Up</span>`;
            }
            if (earningsMeta[nameValue].is_fringe) {
                badgesHtml += ` <span class="badge" style="background: #fef08a; color: #a16207; font-size: 0.7rem; padding: 2px 4px; border-radius: 4px; display: inline-block; margin-top: 2px;">Fringe</span>`;
            }
        }
        
        let typeHtml = '';
        if (idValue) {
            typeHtml += `<input type="hidden" name="payslip_items[${rowIndex}][id]" value="${idValue}">`;
        }
        typeHtml += `
            <input type="hidden" name="payslip_items[${rowIndex}][item_type]" value="${type}">
            <span style="font-weight: 500; color: ${type === 'Deduction' || isTax ? '#900000' : '#2e6c80'};">${type}</span><br>
            <div id="badges-${rowIndex}">${badgesHtml}</div>
        `;

        let listId = type === 'Earning' ? 'earnings-list' : 'deductions-list';
        let nameHtml = `<input type="text" name="payslip_items[${rowIndex}][name]" value="${nameValue}" list="${listId}" class="form-control item-name-input" data-row="${rowIndex}" data-type="${type}" placeholder="Description" required ${isTax ? 'readonly' : ''} oninput="updateBadges(this)">`;
        
        let currHtml = `
            <select name="payslip_items[${rowIndex}][currency]" onchange="calculateGrandTotal()" class="form-control" ${isTax ? 'readonly tabindex="-1" style="pointer-events: none;"' : ''}>
                <option value="USD" ${currValue === 'USD' ? 'selected' : ''}>USD</option>
                <option value="ZWG" ${currValue === 'ZWG' ? 'selected' : ''}>ZWG</option>
            </select>
        `;

        let amtHtml = `<input type="number" name="payslip_items[${rowIndex}][amount]" value="${amtValue}" step="0.01" onchange="calculateGrandTotal()" oninput="calculateGrandTotal()" class="form-control" required ${isTax ? 'readonly' : ''}>`;

        let actionHtml = '';
        if (!isTax) {
            actionHtml = `<button type="button" class="btn-danger" style="padding: 4px 8px;" onclick="removeRow(${rowIndex})"><i class="fa fa-trash"></i></button>`;
        } else {
            actionHtml = `<span style="color: #999; font-size: 0.8rem;">Auto</span>`;
        }

        let permHtml = '';
        if (!isTax) {
            permHtml = `
                <input type="hidden" name="payslip_items[${rowIndex}][is_permanent]" value="0">
                <input type="checkbox" name="payslip_items[${rowIndex}][is_permanent]" value="1" ${isPermanent === '1' ? 'checked' : ''} style="margin: 0;">
            `;
        }

        tr.innerHTML = `
            <td style="padding: 10px;">${typeHtml}</td>
            <td style="padding: 10px;">${nameHtml}</td>
            <td style="padding: 10px;">${currHtml}</td>
            <td style="padding: 10px;">${amtHtml}</td>
            <td style="padding: 10px; text-align: right; vertical-align: middle;">${permHtml}</td>
            <td style="padding: 10px; text-align: center;">${actionHtml}</td>
        `;

        container.appendChild(tr);
        rowIndex++;
        calculateGrandTotal();
    }

    function updateBadges(inputElement) {
        const rowIdx = inputElement.getAttribute('data-row');
        const type = inputElement.getAttribute('data-type');
        const val = inputElement.value;
        const badgesContainer = document.getElementById(`badges-${rowIdx}`);
        
        if (badgesContainer && type === 'Earning') {
            let badgesHtml = '';
            if (val && earningsMeta[val]) {
                if (earningsMeta[val].is_gross_up) {
                    badgesHtml += ` <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 0.7rem; padding: 2px 4px; border-radius: 4px; display: inline-block; margin-top: 2px;">Gross-Up</span>`;
                }
                if (earningsMeta[val].is_fringe) {
                    badgesHtml += ` <span class="badge" style="background: #fef08a; color: #a16207; font-size: 0.7rem; padding: 2px 4px; border-radius: 4px; display: inline-block; margin-top: 2px;">Fringe</span>`;
                }
            }
            badgesContainer.innerHTML = badgesHtml;
        }
    }

    function removeRow(idx) {
        document.getElementById(`row-${idx}`).remove();
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let usdGross = 0; let zwgGross = 0;
        let usdDeductions = 0; let zwgDeductions = 0;

        const rows = document.querySelectorAll('#items-container tr');
        rows.forEach(row => {
            const type = row.querySelector('input[name$="[item_type]"]').value;
            const currency = row.querySelector('select[name$="[currency]"]').value;
            const amountStr = row.querySelector('input[name$="[amount]"]').value;
            const amt = parseFloat(amountStr) || 0;

            if (type === 'Earning') {
                if (currency === 'USD') usdGross += amt;
                else zwgGross += amt;
            } else if (type === 'Deduction' || type === 'Tax') {
                if (currency === 'USD') usdDeductions += amt;
                else zwgDeductions += amt;
            }
        });

        const rate = parseFloat(document.getElementById('exchange-rate').value) || 1.0;

        document.getElementById('usd_gross').value = usdGross.toFixed(2);
        document.getElementById('zwg_gross').value = zwgGross.toFixed(2);
        
        document.getElementById('usd_deductions').value = usdDeductions.toFixed(2);
        document.getElementById('zwg_deductions').value = zwgDeductions.toFixed(2);
        
        document.getElementById('usd_net').value = (usdGross - usdDeductions).toFixed(2);
        document.getElementById('zwg_net').value = (zwgGross - zwgDeductions).toFixed(2);

        const equivGross = usdGross + (zwgGross / rate);
        const equivDeductions = usdDeductions + (zwgDeductions / rate);
        const equivNet = equivGross - equivDeductions;

        document.getElementById('gross_pay').value = equivGross.toFixed(2);
        document.getElementById('total_deductions').value = equivDeductions.toFixed(2);
        document.getElementById('net_pay').value = equivNet.toFixed(2);
    }

    function calculateTaxes() {
        const formData = new FormData(document.getElementById('payslip-form'));
        const formObj = new URLSearchParams(formData).toString();
        
        const btn = event.currentTarget || document.activeElement;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Calculating...';
        btn.disabled = true;

        $.ajax({
            url: "<?= $this->Url->build(['action' => 'calculateTaxes']) ?>",
            type: "POST",
            data: formObj,
            headers: { 'X-CSRF-Token': csrfToken },
            success: function(response) {
                if(response.success) {
                    document.querySelectorAll('.tax-row').forEach(row => row.remove());
                    response.data.forEach(tax => addRow(tax.item_type, tax));
                    
                    if (response.updated_items && response.updated_items.length > 0) {
                        response.updated_items.forEach(ui => {
                            const inp = document.querySelector(`input[name="payslip_items[${ui.index}][amount]"]`);
                            if (inp) {
                                inp.value = ui.amount.toFixed(2);
                            }
                        });
                        // Recalculate totals after inflating any amounts
                        calculateGrandTotal();
                    }
                } else {
                    alert('Error calculating taxes.');
                }
            },
            complete: function() {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Preload existing items if any
        if (existingItems && existingItems.length > 0) {
            existingItems.forEach(item => {
                addRow(item.item_type, item);
            });
        }

        // Fetch permanent items when employee changes
        $('#employee-select').on('change', function() {
            const empId = $(this).val();
            if (empId) {
                $.get("<?= $this->Url->build(['action' => 'getPermanentItems']) ?>?employee_id=" + empId, function(res) {
                    if (res.success) {
                        document.querySelectorAll('.manual-row').forEach(row => row.remove());
                        document.querySelectorAll('.tax-row').forEach(row => row.remove());
                        if (res.data && res.data.length > 0) {
                            res.data.forEach(item => addRow(item.item_type, item));
                            $('#exchange-rate').focus();
                            setTimeout(calculateTaxes, 500); // Auto-calculate after fetch
                        } else {
                            addRow('Earning'); // fallback empty row
                        }
                    }
                });
            }
        });

        // Initialize empty row if none
        if (document.querySelectorAll('#items-container tr').length === 0) {
            addRow('Earning');
        }
    });
</script>
