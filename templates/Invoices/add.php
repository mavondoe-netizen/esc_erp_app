<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoices form content">
            <?= $this->Form->create($invoice) ?>
            <fieldset>
                <legend><?= __('Add Invoice') ?></legend>
                <div class="row">
                    <div class="column"><?= $this->Form->control('date') ?></div>
                    <div class="column"><?= $this->Form->control('manual_reference', ['label' => 'Manual Ref / Serial No.']) ?></div>
                    <div class="column">
                        <div class="quick-add-group">
                            <div class="form-control-wrapper">
                                <?= $this->Form->control('customer_id', ['options' => $customers, 'id' => 'customer-id', 'class' => 'form-control', 'label' => 'Client (Contact)']) ?>
                            </div>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/customers/index?popup=1" data-target-dropdown="customer-id" title="Search/Pick Customer">
                                <i class="fa fa-search"></i>
                            </button>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/customers/add?popup=1" data-target-dropdown="customer-id" title="Add New Customer">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column"><?= $this->Form->control('currency', ['options' => ['USD' => 'USD', 'ZAR' => 'ZAR']]) ?></div>
                    <div class="column"><?= $this->Form->control('description') ?></div>
                    <div class="column"><?= $this->Form->control('status', ['options' => ['Draft' => 'Draft', 'Pending Approval' => 'Pending Approval', 'Approved' => 'Approved', 'Sent' => 'Sent', 'Paid' => 'Paid']]) ?></div>
                </div>

                <h3 style="margin-top: 2rem;">Invoice Items</h3>
                <table id="invoice-items-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Product</th>
                            <th style="width: 8%;">Qty</th>
                            <th style="width: 10%;">Unit Price</th>
                            <th style="width: 8%;">HS Code</th>
                            <th style="width: 8%;">VAT Type</th>
                            <th style="width: 8%;">VAT %</th>
                            <th style="width: 10%;">VAT Amt</th>
                            <th style="width: 12%;">Line Total</th>
                            <th style="width: 5%;"></th>
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
    const productsInfo = <?= json_encode($productsJson) ?>;
    const productsOptions = <?= json_encode($productsOptions) ?>;
    const accountsOptions = <?= json_encode($accounts) ?>;
    const existingItems = <?= json_encode($invoice->invoice_items ?: []) ?>;
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
        const hsCode = data && data.hs_code ? data.hs_code : '';
        const vatType = data && data.vat_type ? data.vat_type : '';
        const vatAmount = data ? data.vat_amount : '0.00';
        const lineTotal = data ? data.line_total : '0.00';
        const itemId = data ? data.id : '';

        let productHtml = itemId ? `<input type="hidden" name="invoice_items[${rowIndex}][id]" value="${itemId}">` : '';
        productHtml += `<select name="invoice_items[${rowIndex}][product_id]" id="product-select-${rowIndex}" onchange="updateProduct(${rowIndex}, this.value)" class="form-control"><option value="">Custom/Other</option>`;
        for (let id in productsOptions) {
            const selected = (id == prodId) ? 'selected' : '';
            productHtml += `<option value="${id}" ${selected}>${productsOptions[id]}</option>`;
        }
        productHtml += `</select>`;

        let defaultAccountId = accId ? accId : (Object.keys(accountsOptions).length > 0 ? Object.keys(accountsOptions)[0] : '');
        let accountHtml = `<input type="hidden" name="invoice_items[${rowIndex}][account_id]" id="account-${rowIndex}" value="${defaultAccountId}">`;

        tr.innerHTML = `
            <td>
                <div style="display: flex; align-items: center; gap: 5px;">
                    ${productHtml}${accountHtml}
                    <button type="button" class="global-quick-add-btn" data-url="/products/index?popup=1" data-target-dropdown="product-select-${rowIndex}" style="padding: 4px 8px; font-size: 0.8rem;" title="Search/Pick Product">
                        <i class="fa fa-search"></i>
                    </button>
                    <button type="button" class="global-quick-add-btn" data-url="/products/add?popup=1" data-target-dropdown="product-select-${rowIndex}" style="padding: 4px 8px; font-size: 0.8rem;" title="Add New Product">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </td>
            <td><input type="number" name="invoice_items[${rowIndex}][quantity]" id="qty-${rowIndex}" step="1" value="${qty}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="invoice_items[${rowIndex}][unit_price]" id="price-${rowIndex}" step="0.01" value="${price}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="text" name="invoice_items[${rowIndex}][hs_code]" id="hs-code-${rowIndex}" class="form-control" value="${hsCode}" placeholder="HS Code" onchange="handleHsCode(${rowIndex})"></td>
            <td><input type="text" name="invoice_items[${rowIndex}][vat_type]" id="vat-type-${rowIndex}" class="form-control" value="${vatType}" placeholder="Type"></td>
            <td><input type="number" name="invoice_items[${rowIndex}][vat_rate]" id="vat-rate-${rowIndex}" step="0.01" value="${vatRate}" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="invoice_items[${rowIndex}][vat_amount]" id="vat-amount-${rowIndex}" step="0.01" value="${vatAmount}" readonly class="form-control" style="background: #f8fafc; border: none;"></td>
            <td><input type="number" name="invoice_items[${rowIndex}][line_total]" id="total-${rowIndex}" step="0.01" value="${lineTotal}" readonly class="form-control" style="background: #f8fafc; border: none; font-weight: 600;"></td>
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
            document.getElementById(`hs-code-${idx}`).value = info.hs_code || '';
            document.getElementById(`vat-type-${idx}`).value = info.vat_type || '';
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

    function handleHsCode(idx) {
        const hsInput = document.getElementById(`hs-code-${idx}`).value;
        const vatRateInput = document.getElementById(`vat-rate-${idx}`);
        const vatTypeInput = document.getElementById(`vat-type-${idx}`);

        if (hsInput === '99001000') {
            vatRateInput.value = '15.50';
            vatTypeInput.value = 'Standard';
        } else if (hsInput === '99002000') {
            vatRateInput.value = '0.00';
            vatTypeInput.value = 'Zero';
        } else if (hsInput === '99003000') {
            vatRateInput.value = '0.00';
            vatTypeInput.value = 'Exempt';
        }
        
        calculateLine(idx);
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
