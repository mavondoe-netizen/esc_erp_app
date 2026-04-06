<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitNote $debitNote
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $suppliers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $debitNote->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $debitNote->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Debit Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="debitNotes form content">
            <?= $this->Form->create($debitNote) ?>
            <fieldset>
                <legend><?= __('Edit Debit Note') ?></legend>
                <?php
                    echo $this->Form->control('supplier_id', ['options' => $suppliers, 'class' => 'form-select']);
                    echo $this->Form->control('date', ['class' => 'form-control']);
                    echo $this->Form->control('reference', ['class' => 'form-control']);
                    echo $this->Form->control('description', ['class' => 'form-control']);
                ?>

                <h4 style="margin-top: 2rem;">Debit Note Items</h4>
                <table id="items-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Product</th>
                            <th style="width: 15%;">Account</th>
                            <th style="width: 8%;">Qty</th>
                            <th style="width: 12%;">Unit Price</th>
                            <th style="width: 10%;">VAT %</th>
                            <th style="width: 12%;">VAT Amt</th>
                            <th style="width: 12%;">Line Total</th>
                            <th style="width: 8%;"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container">
                        <!-- JS will inject rows here -->
                    </tbody>
                </table>
                <button type="button" class="button button-outline" onclick="addRow()" style="margin-top: 1rem;">
                    <i class="fa fa-plus"></i> Add Line Item
                </button>

                <div style="margin-top: 2rem; border-top: 2px solid #eee; padding-top: 1rem; text-align: right;">
                    <div style="font-size: 1.2rem; font-weight: bold;">
                        Grand Total: <?= $this->Form->control('total', ['type' => 'number', 'step' => '0.01', 'readonly' => true, 'label' => false, 'style' => 'display: inline-block; width: 150px; text-align: right; font-weight: bold; border: none; background: transparent; font-size: 1.5rem;']) ?>
                    </div>
                </div>
            </fieldset>
            <div style="margin-top: 2rem;">
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    const productsInfo = <?= json_encode($productsJson ?? []) ?>;
    const productsOptions = <?= json_encode($productsOptions ?? []) ?>;
    const accountsOptions = <?= json_encode($accounts ?? []) ?>;
    const existingItems = <?= json_encode($debitNote->debit_note_items ?: []) ?>;
    let rowIndex = 0;

    function addRow(data = null) {
        const container = document.getElementById('items-container');
        const tr = document.createElement('tr');
        tr.id = `row-${rowIndex}`;

        const prodId = data ? data.product_id : '';
        const accId = data ? data.account_id : '';
        const qty = data ? data.quantity : 1;
        const price = data ? data.unit_price : '0.00';
        const vatRate = data ? data.vat_rate : '0.00';
        const vatAmount = data ? data.vat_amount : '0.00';
        const lineTotal = data ? data.line_total : '0.00';
        const itemId = data ? data.id : '';

        let productHtml = `<input type="hidden" name="debit_note_items[${rowIndex}][id]" value="${itemId}">`;
        productHtml += `<select name="debit_note_items[${rowIndex}][product_id]" onchange="updateProduct(${rowIndex}, this.value)" class="form-control"><option value="">Custom/Other</option>`;
        for (let id in productsOptions) {
            const selected = (id == prodId) ? 'selected' : '';
            productHtml += `<option value="${id}" ${selected}>${productsOptions[id]}</option>`;
        }
        productHtml += `</select>`;

        let accountHtml = `<select name="debit_note_items[${rowIndex}][account_id]" id="account-${rowIndex}" class="form-control">`;
        for (let id in accountsOptions) {
            const selected = (id == accId) ? 'selected' : '';
            accountHtml += `<option value="${id}" ${selected}>${accountsOptions[id]}</option>`;
        }
        accountHtml += `</select>`;

        tr.innerHTML = `
            <td>${productHtml}</td>
            <td>${accountHtml}</td>
            <td><input type="number" name="debit_note_items[${rowIndex}][quantity]" id="qty-${rowIndex}" step="1" value="${qty}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="debit_note_items[${rowIndex}][unit_price]" id="price-${rowIndex}" step="0.01" value="${price}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="debit_note_items[${rowIndex}][vat_rate]" id="vat-rate-${rowIndex}" step="0.01" value="${vatRate}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="debit_note_items[${rowIndex}][vat_amount]" id="vat-amount-${rowIndex}" step="0.01" value="${vatAmount}" readonly class="form-control" style="background: #f8fafc; border: none;"></td>
            <td><input type="number" name="debit_note_items[${rowIndex}][line_total]" id="total-${rowIndex}" step="0.01" value="${lineTotal}" readonly class="form-control" style="background: #f8fafc; border: none; font-weight: 600;"></td>
            <td style="text-align: center;"><button type="button" class="btn-danger" style="padding: 4px 8px;" onclick="removeRow(${rowIndex})"><i class="fa fa-trash"></i></button></td>
        `;

        container.appendChild(tr);
        rowIndex++;
    }

    function removeRow(idx) {
        const row = document.getElementById(`row-${idx}`);
        row.remove();
        calculateGrandTotal();
    }

    function updateProduct(idx, productId) {
        if (productsInfo[productId]) {
            const info = productsInfo[productId];
            document.getElementById(`price-${idx}`).value = info.unit_price;
            document.getElementById(`account-${idx}`).value = info.account_id;
            document.getElementById(`vat-rate-${idx}`).value = info.vat_rate || 0;
            calculateLine(idx);
        }
    }

    function calculateLine(idx) {
        const qty = parseFloat(document.getElementById(`qty-${idx}`).value) || 0;
        const price = parseFloat(document.getElementById(`price-${idx}`).value) || 0;
        const vatRate = parseFloat(document.getElementById(`vat-rate-${idx}`).value) || 0;
        
        const netTotal = qty * price;
        const vatAmount = netTotal * (vatRate / 100);
        const grossTotal = netTotal + vatAmount;

        document.getElementById(`vat-amount-${idx}`).value = vatAmount.toFixed(2);
        document.getElementById(`total-${idx}`).value = grossTotal.toFixed(2);
        
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const totals = document.querySelectorAll('input[name*="[line_total]"]');
        totals.forEach(t => {
            grandTotal += parseFloat(t.value) || 0;
        });
        document.getElementById('total').value = grandTotal.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (existingItems.length > 0) {
            existingItems.forEach(item => addRow(item));
        } else {
            addRow();
        }
    });
</script>
