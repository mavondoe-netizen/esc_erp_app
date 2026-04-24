<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bill $bill
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var array $productsOptions
 * @var array $productsJson
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bills'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bills form content">
            <?= $this->Form->create($bill) ?>
            <fieldset>
                <legend><?= __('Add Bill') ?></legend>
                <div class="row">
                    <div class="column"><?= $this->Form->control('date') ?></div>
                    <div class="column">
                        <div class="quick-add-group">
                            <div class="form-control-wrapper">
                                <?= $this->Form->control('supplier_id', ['options' => $suppliers, 'id' => 'supplier-id', 'class' => 'form-control']) ?>
                            </div>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/suppliers/index?popup=1" data-target-dropdown="supplier-id" title="Search/Pick Supplier">
                                <i class="fa fa-search"></i>
                            </button>
                            <button type="button" class="global-quick-add-btn button button-outline" data-url="/suppliers/add?popup=1" data-target-dropdown="supplier-id" title="Add New Supplier">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column"><?= $this->Form->control('currency', ['options' => ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR']]) ?></div>
                    <div class="column"><?= $this->Form->control('description') ?></div>
                    <div class="column"><?= $this->Form->control('tenant_id', ['options' => $tenants ?? [], 'empty' => true, 'label' => 'Tenant (Optional)']) ?></div>
                    <div class="column"><?= $this->Form->control('status', ['options' => ['Draft' => 'Draft', 'Pending' => 'Pending', 'Paid' => 'Paid']]) ?></div>
                </div>

                <h3 style="margin-top: 2rem;">Bill Items</h3>
                <table id="bill-items-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Product</th>
                            <th style="width: 8%;">Qty</th>
                            <th style="width: 10%;">Unit Price</th>
                            <th style="width: 8%;">HS Code</th>
                            <th style="width: 8%;">VAT Type</th>
                            <th style="width: 8%;">VAT %</th>
                            <th style="width: 10%;">Line Total</th>
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
    let rowIndex = 0;

    function addRow() {
        const container = document.getElementById('items-container');
        const tr = document.createElement('tr');
        tr.id = `row-${rowIndex}`;

        let productHtml = `<select name="bill_items[${rowIndex}][product_id]" id="product-select-${rowIndex}" onchange="updateProduct(${rowIndex}, this.value)" class="form-control"><option value="">Custom/Other</option>`;
        for (let id in productsOptions) {
            productHtml += `<option value="${id}">${productsOptions[id]}</option>`;
        }
        productHtml += `</select>`;

        let defaultAccountId = Object.keys(accountsOptions).length > 0 ? Object.keys(accountsOptions)[0] : '';
        let accountHtml = `<input type="hidden" name="bill_items[${rowIndex}][account_id]" id="account-${rowIndex}" value="${defaultAccountId}">`;

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
            <td><input type="number" name="bill_items[${rowIndex}][quantity]" id="qty-${rowIndex}" step="1" value="1" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="bill_items[${rowIndex}][unit_price]" id="price-${rowIndex}" step="0.01" value="0.00" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="text" name="bill_items[${rowIndex}][hs_code]" id="hs-code-${rowIndex}" class="form-control" placeholder="HS Code"></td>
            <td><input type="text" name="bill_items[${rowIndex}][vat_type]" id="vat-type-${rowIndex}" class="form-control" placeholder="Type"></td>
            <td><input type="number" name="bill_items[${rowIndex}][vat_rate]" id="vat-rate-${rowIndex}" step="0.01" value="0.00" onchange="calculateLine(${rowIndex})" class="form-control"></td>
            <td><input type="number" name="bill_items[${rowIndex}][line_total]" id="total-${rowIndex}" step="0.01" value="0.00" readonly class="form-control" style="background: #f8fafc; border: none; font-weight: 600;"></td>
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

    // Initialize with one row
    document.addEventListener('DOMContentLoaded', function() {
        addRow();
    });
</script>
