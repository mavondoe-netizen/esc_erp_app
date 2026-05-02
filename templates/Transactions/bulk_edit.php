<?php
/**
 * @var \App\View\AppView $this
 * @var array $accounts
 * @var array $customers
 * @var array $suppliers
 * @var array $buildings
 * @var array $tenants
 * @var array $departments
 * @var iterable<\App\Model\Entity\Transaction> $journalLines
 * @var string $groupId
 */
$this->assign('title', 'Edit Bulk Journal Entries');
?>

<style>
.bulk-journal-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 2rem 2.5rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    color: white;
}
.bulk-journal-header h2 { margin: 0; font-size: 1.6rem; font-weight: 700; }
.bulk-journal-header p  { margin: 0.25rem 0 0; opacity: 0.7; font-size: 0.9rem; }
.bulk-journal-header .icon { font-size: 2.5rem; opacity: 0.8; }

.journal-table-wrapper { overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: white; }
.journal-table { width: 100%; border-collapse: collapse; min-width: 1100px; }
.journal-table thead {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}
.journal-table thead th {
    padding: 0.85rem 0.7rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    white-space: nowrap;
    border: none;
}
.journal-table tbody tr { transition: background 0.15s; }
.journal-table tbody tr:hover { background: #f8faff; }
.journal-table td { padding: 0.45rem 0.4rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
.journal-table td input,
.journal-table td select {
    width: 100%;
    padding: 0.45rem 0.55rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.83rem;
    background: #fafafa;
    transition: border 0.2s, box-shadow 0.2s;
    box-sizing: border-box;
}
.journal-table td input:focus,
.journal-table td select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    background: white;
}
.journal-table td select.no-s2 { appearance: auto; }
.del-row-btn {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 1.1rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    transition: background 0.15s;
}
.del-row-btn:hover { background: #fee2e2; }

.journal-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}
.btn-add-row {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.3rem;
    background: #f1f5f9;
    color: #1e293b;
    border: 1px dashed #94a3b8;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-add-row:hover { background: #e2e8f0; border-color: #6366f1; color: #6366f1; }

.btn-post {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(99,102,241,0.35);
}
.btn-post:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.45); }
.btn-post:active { transform: translateY(0); }

.row-num-badge {
    display: inline-block;
    background: #e2e8f0;
    color: #64748b;
    border-radius: 6px;
    padding: 0.1rem 0.45rem;
    font-size: 0.75rem;
    font-weight: 700;
    min-width: 24px;
    text-align: center;
}
.debit-row  { border-left: 3px solid #22c55e !important; }
.credit-row { border-left: 3px solid #ef4444 !important; }
</style>

<div class="bulk-journal-header">
    <div class="icon"><i class="fas fa-edit"></i></div>
    <div>
        <h2>Edit Bulk Journal Entries</h2>
        <p>Modify lines for journal group: <span style="font-family: monospace; background: rgba(255,255,255,0.2); padding: 2px 6px; border-radius: 4px;"><?= h($groupId) ?></span></p>
    </div>
</div>

<?= $this->Form->create(null, ['url' => ['action' => 'bulkEdit', $groupId], 'id' => 'bulk-journal-form']) ?>

<div class="journal-table-wrapper">
    <table class="journal-table no-dt">
        <thead>
            <tr>
                <th>#</th>
                <th>Date <span style="color:#f87171">*</span></th>
                <th>Description <span style="color:#f87171">*</span></th>
                <th>Currency <span style="color:#f87171">*</span></th>
                <th>Amount <span style="color:#f87171">*</span></th>
                <th>Type <span style="color:#f87171">*</span></th>
                <th>Account <span style="color:#f87171">*</span></th>
                <th>Customer</th>
                <th>Supplier</th>
                <th>Building</th>
                <th>Tenant</th>
                <th>Department</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="journal-rows">
            <!-- Rows injected by JS -->
        </tbody>
    </table>
</div>

<div class="journal-actions">
    <button type="button" id="add-row-btn" class="btn-add-row">
        <i class="fas fa-plus-circle"></i> Add Row
    </button>
    <div style="flex-grow: 1;"></div>
    <div id="balance-indicator" style="padding: 0.75rem 1.5rem; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem;">
        <span style="color: #64748b;">Net Balance:</span>
        <span id="running-total">0.00</span>
        <i id="balance-status" class="fas fa-circle-exclamation" style="color: #f59e0b;"></i>
    </div>
    <button type="submit" id="submit-btn" class="btn-post">
        <i class="fas fa-save"></i> Save Changes
    </button>
    <?= $this->Html->link('<i class="fas fa-times"></i> Cancel', ['action' => 'index'], [
        'escape' => false,
        'style' => 'padding:0.65rem 1.3rem; border-radius:10px; background:#f1f5f9; color:#64748b; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:0.5rem;'
    ]) ?>
</div>

<?= $this->Form->end() ?>

<script>
(function() {
    function buildOptions(data, emptyLabel, selectedValue = '') {
        let html = `<option value="">${emptyLabel}</option>`;
        if (Array.isArray(data)) {
            data.forEach(([id, name]) => { 
                const selected = (String(id) === String(selectedValue)) ? 'selected' : '';
                html += `<option value="${id}" ${selected}>${name}</option>`; 
            });
        } else {
            Object.entries(data).forEach(([id, name]) => { 
                const selected = (String(id) === String(selectedValue)) ? 'selected' : '';
                html += `<option value="${id}" ${selected}>${name}</option>`; 
            });
        }
        return html;
    }

    // Serialise PHP arrays into JS
    const accounts    = <?= json_encode(is_array($accounts) ? $accounts : iterator_to_array($accounts)) ?>;
    const customers   = <?= json_encode(is_array($customers) ? $customers : iterator_to_array($customers)) ?>;
    const suppliers   = <?= json_encode(is_array($suppliers) ? $suppliers : iterator_to_array($suppliers)) ?>;
    const buildings   = <?= json_encode(is_array($buildings) ? $buildings : iterator_to_array($buildings)) ?>;
    const tenants     = <?= json_encode(is_array($tenants) ? $tenants : iterator_to_array($tenants)) ?>;
    const departments = <?= json_encode(is_array($departments) ? $departments : iterator_to_array($departments)) ?>;

    const existingLines = <?= json_encode(array_values(array_map(function($line) {
        return [
            'id' => $line->id,
            'date' => $line->date ? $line->date->format('Y-m-d') : date('Y-m-d'),
            'description' => $line->description,
            'currency' => $line->currency,
            'amount' => str_replace(',', '', (string)$line->amount),
            'type' => (strtolower(trim((string)$line->type)) === 'debit' || strtolower(trim((string)$line->type)) === '1') ? 'Debit' : 'Credit',
            'account_id' => $line->account_id,
            'customer_id' => $line->customer_id,
            'supplier_id' => $line->supplier_id,
            'building_id' => $line->building_id,
            'tenant_id' => $line->tenant_id,
            'department_id' => $line->department_id,
        ];
    }, is_array($journalLines) ? $journalLines : $journalLines->toArray()))) ?>;

    let rowIndex = 0;

    function addRow(data = null) {
        const today = new Date().toISOString().split('T')[0];
        const tbody = document.getElementById('journal-rows');
        const i = rowIndex++;

        const isExisting = data !== null;
        const d_id = data && data.id ? `<input type="hidden" name="rows[${i}][id]" value="${data.id}">` : '';
        const d_date = data && data.date ? data.date : today;
        const d_desc = data && data.description ? data.description : '';
        const d_curr = data && data.currency ? data.currency : 'USD';
        const d_amt = data && data.amount ? parseFloat(data.amount).toFixed(2) : '';
        const d_type = data && data.type ? data.type : '1';
        const d_acc = data && data.account_id ? data.account_id : '';
        const d_cus = data && data.customer_id ? data.customer_id : '';
        const d_sup = data && data.supplier_id ? data.supplier_id : '';
        const d_bld = data && data.building_id ? data.building_id : '';
        const d_ten = data && data.tenant_id ? data.tenant_id : '';
        const d_dep = data && data.department_id ? data.department_id : '';

        const tr = document.createElement('tr');
        tr.dataset.rowIndex = i;
        tr.innerHTML = `
            <td>${d_id}<span class="row-num-badge">${i + 1}</span></td>
            <td><input type="date" name="rows[${i}][date]" value="${d_date}" required></td>
            <td><input type="text" name="rows[${i}][description]" value="${d_desc.replace(/"/g, '&quot;')}" placeholder="e.g. Rent income" required></td>
            <td>
                <select name="rows[${i}][currency]" class="no-s2" required>
                    <option value="USD" ${d_curr === 'USD' ? 'selected' : ''}>USD</option>
                    <option value="ZWG" ${d_curr === 'ZWG' ? 'selected' : ''}>ZWG</option>
                    <option value="ZAR" ${d_curr === 'ZAR' ? 'selected' : ''}>ZAR</option>
                    <option value="GBP" ${d_curr === 'GBP' ? 'selected' : ''}>GBP</option>
                </select>
            </td>
            <td><input type="number" name="rows[${i}][amount]" step="0.01" value="${d_amt}" placeholder="0.00" class="amount-input" required></td>
            <td>
                <select name="rows[${i}][type]" class="no-s2 type-select" required>
                    <option value="Debit" ${d_type === 'Debit' ? 'selected' : ''}>Debit</option>
                    <option value="Credit" ${d_type === 'Credit' ? 'selected' : ''}>Credit</option>
                </select>
            </td>
            <td>
                <select name="rows[${i}][account_id]" class="no-s2" required>
                    ${buildOptions(accounts, '-- Account --', d_acc)}
                </select>
            </td>
            <td>
                <select name="rows[${i}][customer_id]" class="no-s2">
                    ${buildOptions(customers, '-- Customer --', d_cus)}
                </select>
            </td>
            <td>
                <select name="rows[${i}][supplier_id]" class="no-s2">
                    ${buildOptions(suppliers, '-- Supplier --', d_sup)}
                </select>
            </td>
            <td>
                <select name="rows[${i}][building_id]" class="no-s2">
                    ${buildOptions(buildings, '-- Bldg --', d_bld)}
                </select>
            </td>
            <td>
                <select name="rows[${i}][tenant_id]" class="no-s2">
                    ${buildOptions(tenants, '-- Tenant --', d_ten)}
                </select>
            </td>
            <td>
                <select name="rows[${i}][department_id]" class="no-s2">
                    ${buildOptions(departments, '-- Dept --', d_dep)}
                </select>
            </td>
            <td>
                <button type="button" class="del-row-btn" title="Remove row"><i class="fas fa-trash-alt"></i></button>
            </td>
        `;

        // Colour the row border based on type
        const typeSelect = tr.querySelector('.type-select');
        typeSelect.addEventListener('change', function() {
            tr.classList.remove('debit-row', 'credit-row');
            if (this.value === 'Debit') tr.classList.add('debit-row');
            else                        tr.classList.add('credit-row');
        });
        // Trigger initial colour
        typeSelect.dispatchEvent(new Event('change'));

        tr.querySelector('.del-row-btn').addEventListener('click', function() {
            tr.remove();
            renumberRows();
            updateBalance();
        });

        tbody.appendChild(tr);
    }

    function renumberRows() {
        document.querySelectorAll('#journal-rows tr').forEach((tr, idx) => {
            const badge = tr.querySelector('.row-num-badge');
            if (badge) badge.textContent = idx + 1;
        });
    }

    function updateBalance() {
        const rows = document.querySelectorAll('#journal-rows tr');
        let total = 0;
        let currencies = new Set();

        rows.forEach(tr => {
            const val = parseFloat(tr.querySelector('.amount-input').value) || 0;
            const currency = tr.querySelector('select[name*="[currency]"]').value;
            currencies.add(currency);
            
            const type = tr.querySelector('.type-select').value;
            // Usually Journals: Debit - Credit = 0
            total += (type === 'Debit' ? val : -val);
        });

        const display = document.getElementById('running-total');
        const status = document.getElementById('balance-status');
        
        display.textContent = total.toFixed(2);
        
        if (Math.abs(total) < 0.001) {
            display.style.color = '#22c55e';
            status.className = 'fas fa-check-circle';
            status.style.color = '#22c55e';
        } else {
            display.style.color = '#ef4444';
            status.className = 'fas fa-circle-exclamation';
            status.style.color = '#f59e0b';
        }

        // Warning if multiple currencies are mixed (balancing amount only works if currency is same)
        if (currencies.size > 1) {
            display.title = "Multiple currencies detected. Balancing on Amount is only an estimate. Backend will validate ZWG conversion.";
            display.style.borderBottom = "1px dotted #94a3b8";
        } else {
            display.title = "";
            display.style.borderBottom = "none";
        }
    }

    document.getElementById('add-row-btn').addEventListener('click', function() {
        addRow();
        // Attach listeners to new row
        const newTr = document.querySelector('#journal-rows tr:last-child');
        newTr.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', updateBalance);
        });
    });

    // Delegated listener for initial rows and dynamically added rows
    document.getElementById('journal-rows').addEventListener('input', function(e) {
        if (e.target.matches('input, select')) {
            updateBalance();
        }
    });

    document.getElementById('bulk-journal-form').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('#journal-rows tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Please add at least one journal row before posting.');
            return;
        }

        let total = 0;
        let currencies = new Set();
        rows.forEach(tr => {
            const val = parseFloat(tr.querySelector('.amount-input').value) || 0;
            const type = tr.querySelector('.type-select').value;
            const currency = tr.querySelector('select[name*="[currency]"]').value;
            currencies.add(currency);
            total += (type === 'Debit' ? val : -val);
        });

        // If multi-currency, we allow it to pass JS validation and let the backend handle the ZWG balance check
        if (currencies.size === 1 && Math.abs(total) > 0.001) {
            e.preventDefault();
            alert('The journal entry is unbalanced (Balance: ' + total.toFixed(2) + '). Net balance must be 0.00.');
        } else if (currencies.size > 1) {
            // Optional: confirm if they want to proceed despite multi-currency
            // For now, just allow it.
        }
    });

    // Start with existing rows
    if (existingLines.length > 0) {
        existingLines.forEach(line => addRow(line));
    } else {
        addRow();
        addRow();
    }
    updateBalance();
})();
</script>
