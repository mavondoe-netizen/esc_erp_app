<?php
/**
 * @var \App\View\AppView $this
 * @var array $accounts
 * @var array $customers
 * @var array $suppliers
 * @var array $departments
 */
$this->assign('title', 'Post Bulk Journal Entries');
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
    <div class="icon"><i class="fas fa-book-open"></i></div>
    <div>
        <h2>Post Bulk Journal Entries</h2>
        <p>Enter multiple ledger lines below and submit them all in one transaction.</p>
    </div>
</div>

<?= $this->Form->create(null, ['url' => ['action' => 'bulkAdd'], 'id' => 'bulk-journal-form']) ?>

<div class="journal-table-wrapper">
    <table class="journal-table no-dt">
        <thead>
            <tr>
                <th>#</th>
                <th>Date <span style="color:#f87171">*</span></th>
                <th>Description <span style="color:#f87171">*</span></th>
                <th>Currency <span style="color:#f87171">*</span></th>
                <th>Amount <span style="color:#f87171">*</span></th>
                <th>ZWG</th>
                <th>Type <span style="color:#f87171">*</span></th>
                <th>Account <span style="color:#f87171">*</span></th>
                <th>Customer</th>
                <th>Supplier</th>
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
    <button type="submit" class="btn-post">
        <i class="fas fa-paper-plane"></i> Post All Journals
    </button>
    <?= $this->Html->link('<i class="fas fa-times"></i> Cancel', ['action' => 'index'], [
        'escape' => false,
        'style' => 'padding:0.65rem 1.3rem; border-radius:10px; background:#f1f5f9; color:#64748b; text-decoration:none; font-weight:600; display:inline-flex; align-items:center; gap:0.5rem;'
    ]) ?>
</div>

<?= $this->Form->end() ?>

<script>
(function() {
    // Serialise PHP arrays into JS
    const accounts    = <?= json_encode(is_array($accounts) ? $accounts : iterator_to_array($accounts)) ?>;
    const customers   = <?= json_encode(is_array($customers) ? $customers : iterator_to_array($customers)) ?>;
    const suppliers   = <?= json_encode(is_array($suppliers) ? $suppliers : iterator_to_array($suppliers)) ?>;
    const departments = <?= json_encode(is_array($departments) ? $departments : iterator_to_array($departments)) ?>;

    function buildOptions(data, emptyLabel) {
        let html = `<option value="">${emptyLabel}</option>`;
        if (Array.isArray(data)) {
            data.forEach(([id, name]) => { html += `<option value="${id}">${name}</option>`; });
        } else {
            Object.entries(data).forEach(([id, name]) => { html += `<option value="${id}">${name}</option>`; });
        }
        return html;
    }

    let rowIndex = 0;

    function addRow() {
        const today = new Date().toISOString().split('T')[0];
        const tbody = document.getElementById('journal-rows');
        const i = rowIndex++;

        const tr = document.createElement('tr');
        tr.dataset.rowIndex = i;
        tr.innerHTML = `
            <td><span class="row-num-badge">${i + 1}</span></td>
            <td><input type="date" name="rows[${i}][date]" value="${today}" required></td>
            <td><input type="text" name="rows[${i}][description]" placeholder="e.g. Rent income" required></td>
            <td>
                <select name="rows[${i}][currency]" class="no-s2" required>
                    <option value="USD">USD</option>
                    <option value="ZWG">ZWG</option>
                    <option value="ZAR">ZAR</option>
                    <option value="GBP">GBP</option>
                </select>
            </td>
            <td><input type="number" name="rows[${i}][amount]" step="0.01" placeholder="0.00" required></td>
            <td><input type="number" name="rows[${i}][zwg]" step="0.01" placeholder="0.00"></td>
            <td>
                <select name="rows[${i}][type]" class="no-s2 type-select" required>
                    <option value="1">Debit</option>
                    <option value="2">Credit</option>
                </select>
            </td>
            <td>
                <select name="rows[${i}][account_id]" class="no-s2" required>
                    ${buildOptions(accounts, '-- Account --')}
                </select>
            </td>
            <td>
                <select name="rows[${i}][customer_id]" class="no-s2">
                    ${buildOptions(customers, '-- Customer --')}
                </select>
            </td>
            <td>
                <select name="rows[${i}][supplier_id]" class="no-s2">
                    ${buildOptions(suppliers, '-- Supplier --')}
                </select>
            </td>
            <td>
                <select name="rows[${i}][department_id]" class="no-s2">
                    ${buildOptions(departments, '-- Dept --')}
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
            if (this.value === '1') tr.classList.add('debit-row');
            else                   tr.classList.add('credit-row');
        });
        // Trigger initial colour
        typeSelect.dispatchEvent(new Event('change'));

        tr.querySelector('.del-row-btn').addEventListener('click', function() {
            tr.remove();
            renumberRows();
        });

        tbody.appendChild(tr);
    }

    function renumberRows() {
        document.querySelectorAll('#journal-rows tr').forEach((tr, idx) => {
            const badge = tr.querySelector('.row-num-badge');
            if (badge) badge.textContent = idx + 1;
        });
    }

    document.getElementById('add-row-btn').addEventListener('click', addRow);

    document.getElementById('bulk-journal-form').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('#journal-rows tr');
        if (rows.length === 0) {
            e.preventDefault();
            alert('Please add at least one journal row before posting.');
        }
    });

    // Start with 3 blank rows
    addRow();
    addRow();
    addRow();
})();
</script>
