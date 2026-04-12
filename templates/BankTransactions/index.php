<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BankTransaction> $bankTransactions
 * @var array $accounts
 */
?>
<div class="bankTransactions index content">
    <div class="row" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div class="column">
            <h3><i class="fas fa-university"></i> Bank Reconciliation Dashboard</h3>
            <p>Compare imported bank statements with your system ledger.</p>
        </div>
        <div class="column" style="text-align: right;">
            <?= $this->Html->link(__('Upload CSV Statement'), ['action' => 'import'], ['class' => 'button']) ?>
        </div>
    </div>

    <!-- Stats & Progress -->
    <div class="row">
        <div class="column column-33">
            <div class="card" style="background: #f1f8fa; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <h5 style="margin-top: 0;">Unreconciled Bank Lines</h5>
                <h2 style="color: #2e6c80;"><?= count($bankTransactions) ?></h2>
                <small>Requires categorization or matching</small>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div style="background:#fff; border:1px solid #e0e0e0; border-radius:10px; padding:15px 20px; margin-bottom:15px; display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
        <div>
            <label style="font-size:0.8em; color:#555; display:block; margin-bottom:3px;"><i class="fas fa-search"></i> Search</label>
            <input type="text" id="bank-search" placeholder="Description / reference..." style="margin:0; width:230px;">
        </div>
        <div>
            <label style="font-size:0.8em; color:#555; display:block; margin-bottom:3px;"><i class="fas fa-calendar-alt"></i> From Date</label>
            <input type="date" id="filter-date-from" style="margin:0; width:150px;">
        </div>
        <div>
            <label style="font-size:0.8em; color:#555; display:block; margin-bottom:3px;"><i class="fas fa-calendar-alt"></i> To Date</label>
            <input type="date" id="filter-date-to" style="margin:0; width:150px;">
        </div>
        <div>
            <label style="font-size:0.8em; color:#555; display:block; margin-bottom:3px;"><i class="fas fa-exchange-alt"></i> Type</label>
            <select id="filter-type" class="no-s2" style="margin:0; width:130px;">
                <option value="">All</option>
                <option value="credit">Credits (+)</option>
                <option value="debit">Debits (−)</option>
            </select>
        </div>
        <div>
            <button id="btn-clear-filters" class="button button-outline" style="margin:0; font-size:0.85em;"><i class="fas fa-times"></i> Clear Filters</button>
        </div>

        <!-- Bulk Categorize Bar (inline, shows on row selection) -->
        <div id="custom-bulk-wrapper" style="display:none; flex:1; min-width:100%; background:#e8f4fd; padding:12px 15px; border-radius:8px; margin-top:5px;">
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <strong style="white-space:nowrap;"><i class="fas fa-check-square"></i> Bulk Categorize <span id="custom-bulk-count">0</span> selected:</strong>
                <select id="custom-bulk-account" class="no-s2" style="margin:0; flex: 1; min-width:200px; max-width:350px;">
                    <option value="">-- Choose Account --</option>
                    <?php foreach ($accounts as $id => $name): ?>
                        <option value="<?= $id ?>"><?= h($name) ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="btn-custom-bulk" class="button" style="margin:0; background:#2e6c80; border-color:#2e6c80; white-space:nowrap;">
                    <i class="fas fa-tags"></i> Categorize All
                </button>
                <button id="btn-deselect-all" class="button button-outline" style="margin:0; white-space:nowrap;">
                    <i class="fas fa-minus-square"></i> Deselect All
                </button>
                <span id="bulk-loader" style="display:none; color:#2e6c80;"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column column-75">
            <div class="card" style="padding: 20px; border-radius: 12px; background: white; border: 1px solid #eee;">
                <div class="table-responsive">
                    <table id="bank-tx-table" class="no-dt" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-rows" title="Select all visible rows"></th>
                                <th>Date</th>
                                <th>Bank Details</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Reference</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bankTransactions as $tx): ?>
                            <tr id="row-<?= $tx->id ?>" class="<?= isset($tx->suggested_account_id) ? 'suggested-row' : '' ?>"
                                data-date="<?= h($tx->date) ?>"
                                data-amount="<?= (float)$tx->amount ?>">
                                <td style="text-align: center;"><input type="checkbox" class="row-checkbox" value="<?= $tx->id ?>"></td>
                                <td><?= $tx->date ? h($tx->date->format('d/m/Y')) : '' ?></td>
                                <td>
                                    <span style="font-weight: 500;"><?= h($tx->description) ?></span>
                                    <?php if (isset($tx->suggested_account_id)): ?>
                                        <span class="badge" style="background: #e8f4fd; color: #2e6c80; font-size: 0.7em; padding: 2px 6px; border-radius: 4px; margin-left: 5px;">Suggested Match</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="badge" style="background: #eee; padding: 2px 8px; border-radius: 4px; color: #666;">
                                        <?= $tx->hasValue('bank_account') ? h($tx->bank_account->name) : 'N/A' ?>
                                    </small>
                                </td>
                                <td>
                                    <strong style="color: <?= $tx->amount > 0 ? '#27ae60' : '#e74c3c' ?>;">
                                        <?= $this->Number->format($tx->amount) ?>
                                    </strong>
                                </td>
                                <td><?= h($tx->reference) ?></td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: center;">
                                        <div style="display:flex; gap:5px; align-items:center;">
                                            <select class="categorize-select no-s2" data-id="<?= $tx->id ?>" style="margin-bottom:0; padding:5px; font-size:0.85em; width:150px;">
                                                <option value="">-- Categorize --</option>
                                                <?php foreach ($accounts as $id => $name): ?>
                                                    <option value="<?= $id ?>" <?= (isset($tx->suggested_account_id) && $tx->suggested_account_id == $id) ? 'selected' : '' ?>><?= h($name) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="button button-outline button-small match-btn" data-id="<?= $tx->id ?>" style="margin-bottom:0; font-size:0.7em; padding: 0 10px;">OK</button>
                                            <button class="button button-clear button-small split-btn" data-id="<?= $tx->id ?>" data-amount="<?= (float)$tx->amount ?>" style="margin-bottom:0; font-size:0.7em; padding:0; color:#3498db; text-decoration:underline;">Split</button>
                                            <button class="button button-clear button-small delete-btn" data-id="<?= $tx->id ?>" style="margin-bottom:0; font-size:0.7em; padding:0; color:#e74c3c; text-decoration:underline; margin-left:5px;">Delete</button>
                                        </div>
                                        <label style="font-size: 0.7em; display: flex; align-items: center; gap: 4px; cursor: pointer; margin-top:3px;">
                                            <input type="checkbox" class="save-rule-check" data-id="<?= $tx->id ?>" <?= isset($tx->suggested_account_id) ? 'disabled' : '' ?>> Remember for future
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="column column-25">
            <div class="card" style="padding: 20px; border-radius: 12px; background: #fafafa; border: 1px solid #ddd; position: sticky; top: 20px;">
                <h5 style="margin-top: 0;"><i class="fas fa-info-circle"></i> Reconciliation Guide</h5>
                <p style="font-size: 0.85em; color: #666;">
                    Select an account from the dropdown next to a bank transaction to <strong>Categorize on the Fly</strong>. 
                </p>
                <p style="font-size: 0.85em; color: #666;">
                    <strong>Bulk:</strong> Tick rows (or use the header checkbox to select all visible), then pick an account from the bar above the table.
                </p>
                <div style="margin-top: 20px; font-size: 0.8em;">
                    <strong>Legend:</strong>
                    <ul style="padding-left: 15px; margin-top: 10px;">
                        <li><span style="color: #27ae60; font-weight: bold;">Green</span>: Credit (Incoming)</li>
                        <li><span style="color: #e74c3c; font-weight: bold;">Red</span>: Debit (Outgoing)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent History Section -->
    <div class="row" style="margin-top: 40px;">
        <div class="column">
            <h4 style="color: #666; font-size: 1.1em;"><i class="fas fa-history"></i> Recent Activity (Last 15 Reconciled)</h4>
            <div class="card" style="padding: 10px; border-radius: 12px; background: #fdfdfd; border: 1px dashed #ccc;">
                <div class="table-responsive">
                    <table style="width: 100%; font-size: 0.8em; margin-bottom:0;">
                        <thead>
                            <tr style="border-bottom: 2px solid #eee;">
                                <th>Date</th>
                                <th>Description</th>
                                <th>Bank Account</th>
                                <th>Amount</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentReconciled->isEmpty()): ?>
                                <tr><td colspan="5" style="text-align: center; color: #999; padding: 15px;">No recently reconciled transactions.</td></tr>
                            <?php else: ?>
                                <?php foreach ($recentReconciled as $rec): ?>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td><?= $rec->date ? h($rec->date->format('d/m/Y')) : '' ?></td>
                                    <td><?= h($rec->description) ?></td>
                                    <td><small><?= $rec->hasValue('bank_account') ? h($rec->bank_account->name) : 'N/A' ?></small></td>
                                    <td><strong style="color: <?= $rec->amount > 0 ? '#27ae60' : '#e74c3c' ?>;"><?= $this->Number->format($rec->amount) ?></strong></td>
                                    <td style="text-align: right;">
                                        <button class="button button-clear button-small unreconcile-btn" data-id="<?= $rec->id ?>" title="Undo Reconcile" style="padding:0; height:auto; line-height:1; color:#2e6c80; font-weight:bold;">
                                            <i class="fas fa-undo"></i> UNDO
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p style="font-size: 0.75em; color: #888; margin-top: 10px;">
                <i class="fas fa-lightbulb"></i> "Undo" will delete the system ledger entries and move the transaction back to the unreconciled list above.
            </p>
        </div>
    </div>
</div>


<!-- Split Modal -->
<div id="splitModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:white; margin:10% auto; padding:20px; border-radius:12px; width:600px; box-shadow:0 15px 50px rgba(0,0,0,0.15);">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h3>Split Transaction</h3>
            <button class="button button-clear close-modal" style="font-size:1.5em; line-height:0;">&times;</button>
        </div>
        
        <div style="margin-bottom:20px; background:#f9f9f9; padding:15px; border-radius:8px;">
            <div style="display:flex; justify-content:space-between;">
                <span>Total Bank Amount:</span>
                <strong id="modal-total-display">$0.00</strong>
            </div>
            <div style="display:flex; justify-content:space-between; color:#e74c3c; margin-top:5px;">
                <span>Remaining to Allocate:</span>
                <strong id="modal-remaining-display">$0.00</strong>
            </div>
        </div>

        <form id="splitForm">
            <input type="hidden" id="modal-bank-tx-id">
            <input type="hidden" id="modal-target-amount">
            <div id="split-rows-container">
                <!-- Dynamic Rows -->
            </div>
            
            <div style="margin-top:15px; display:flex; justify-content:space-between;">
                <button type="button" class="button button-outline add-split-row">+ Add Account</button>
                <button type="submit" class="button btn-save-split">Save Split Reconciliation</button>
            </div>
        </form>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrfToken"]').attr('content');
    const accountOptions = <?= json_encode($accounts) ?>;

    // ─── DataTable Init ────────────────────────────────────────────────────────
    const dt = $('#bank-tx-table').DataTable({
        order: [[1, 'desc']],
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: [0, 6] }
        ],
        dom: 'tip' // table, info, pagination — we use our own search bar
    });

    // ─── Custom Search ─────────────────────────────────────────────────────────
    $('#bank-search').on('keyup input', function() {
        dt.search($(this).val()).draw();
        syncBulkCount();
    });

    // ─── Date Range Filter ─────────────────────────────────────────────────────
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'bank-tx-table') return true;
        const from = $('#filter-date-from').val();
        const to   = $('#filter-date-to').val();
        const rowDate = $(settings.aoData[dataIndex].nTr).data('date');
        if (from && rowDate < from) return false;
        if (to   && rowDate > to)   return false;
        return true;
    });

    // ─── Type Filter ──────────────────────────────────────────────────────────
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'bank-tx-table') return true;
        const type = $('#filter-type').val();
        if (!type) return true;
        const amount = parseFloat($(dt.row(dataIndex).node()).data('amount'));
        if (type === 'credit' && amount < 0) return false;
        if (type === 'debit'  && amount > 0) return false;
        return true;
    });

    $('#filter-date-from, #filter-date-to, #filter-type').on('change', function() {
        dt.draw();
        syncBulkCount();
    });

    $('#btn-clear-filters').on('click', function() {
        $('#bank-search').val('');
        $('#filter-date-from, #filter-date-to').val('');
        $('#filter-type').val('');
        $('#select-all-rows').prop('checked', false);
        dt.search('').draw();
        syncBulkCount();
    });

    // ─── Select All (current visible page only) ────────────────────────────────
    $(document).on('change', '#select-all-rows', function() {
        dt.rows({ page: 'current' }).nodes().to$().find('.row-checkbox').prop('checked', this.checked);
        syncBulkCount();
    });

    $(document).on('change', '.row-checkbox', function() {
        if (!this.checked) $('#select-all-rows').prop('checked', false);
        syncBulkCount();
    });

    function syncBulkCount() {
        const count = $('.row-checkbox:checked').length;
        $('#custom-bulk-count').text(count);
        if (count > 0) {
            $('#custom-bulk-wrapper').slideDown(150);
        } else {
            $('#custom-bulk-wrapper').slideUp(150);
        }
    }

    $('#btn-deselect-all').on('click', function() {
        $('.row-checkbox').prop('checked', false);
        $('#select-all-rows').prop('checked', false);
        syncBulkCount();
    });

    // ─── Bulk Categorize ───────────────────────────────────────────────────────
    $('#btn-custom-bulk').on('click', function() {
        const ids       = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
        const accountId = $('#custom-bulk-account').val();

        if (!accountId) { alert('Please select a target account first.'); return; }
        if (!confirm(`Categorize ${ids.length} selected transaction(s)?`)) return;

        $('#btn-custom-bulk').prop('disabled', true);
        $('#bulk-loader').show();

        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiBulkCategorize']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { ids: ids, account_id: accountId },
            success: function(res) {
                if (res.success) {
                    ids.forEach(function(id) {
                        const rowNode = document.getElementById('row-' + id);
                        if (rowNode) dt.row(rowNode).remove();
                    });
                    dt.draw(false);
                    $('#select-all-rows').prop('checked', false);
                    syncBulkCount();
                    $('#btn-custom-bulk').prop('disabled', false);
                    $('#bulk-loader').hide();
                } else {
                    alert('Error: ' + res.message);
                    $('#btn-custom-bulk').prop('disabled', false);
                    $('#bulk-loader').hide();
                }
            },
            error: function() {
                alert('Bulk categorization failed.');
                $('#btn-custom-bulk').prop('disabled', false);
                $('#bulk-loader').hide();
            }
        });
    });

    // ─── Individual Categorize ─────────────────────────────────────────────────
    $(document).on('click', '.match-btn', function() {
        const bankTxId  = $(this).data('id');
        const select    = $(`.categorize-select[data-id="${bankTxId}"]`);
        const accountId = select.val();
        const saveRule  = $(`.save-rule-check[data-id="${bankTxId}"]`).is(':checked');

        if (!accountId) { alert('Please select an account first.'); return; }

        $(this).prop('disabled', true).text('...');
        select.prop('disabled', true);

        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiCategorize']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { bank_transaction_id: bankTxId, account_id: accountId, save_rule: saveRule ? 1 : 0 },
            success: function(res) {
                if (res.success) {
                    const rowNode = document.getElementById('row-' + bankTxId);
                    if (rowNode) dt.row(rowNode).remove().draw(false);
                } else {
                    alert('Error: ' + res.message);
                    $(`.match-btn[data-id="${bankTxId}"]`).prop('disabled', false).text('OK');
                    select.prop('disabled', false);
                }
            },
            error: function() {
                alert('Connection failed.');
                $(`.match-btn[data-id="${bankTxId}"]`).prop('disabled', false).text('OK');
                select.prop('disabled', false);
            }
        });
    });

    // ─── Delete ────────────────────────────────────────────────────────────────
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (!confirm('Delete this transaction from the import?')) return;
        $(this).prop('disabled', true);
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiDelete']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    const rowNode = document.getElementById('row-' + id);
                    if (rowNode) dt.row(rowNode).remove().draw(false);
                } else {
                    alert('Error: ' + res.message);
                    $(`.delete-btn[data-id="${id}"]`).prop('disabled', false);
                }
            },
            error: function() { alert('Delete failed.'); $(`.delete-btn[data-id="${id}"]`).prop('disabled', false); }
        });
    });

    // ─── Split Modal ───────────────────────────────────────────────────────────
    $(document).on('click', '.split-btn', function() {
        const id     = $(this).data('id');
        const amount = Math.abs(parseFloat($(this).data('amount')));
        $('#modal-bank-tx-id').val(id);
        $('#modal-target-amount').val(amount);
        $('#modal-total-display').text('$' + amount.toFixed(2));
        $('#split-rows-container').empty();
        addSplitRow(); addSplitRow();
        updateRemaining();
        $('#splitModal').fadeIn();
    });

    $('.close-modal').click(function() { $('#splitModal').fadeOut(); });

    function addSplitRow() {
        let opts = '<option value="">-- Choose Account --</option>';
        for (const [id, label] of Object.entries(accountOptions)) opts += `<option value="${id}">${label}</option>`;
        $('#split-rows-container').append(`
            <div class="split-row" style="display:flex; gap:10px; margin-bottom:10px;">
                <select name="account_id" style="flex:2;" required>${opts}</select>
                <input type="number" name="amount" placeholder="Amount" step="any" style="flex:1;" class="split-amount-input" required>
                <button type="button" class="button button-clear remove-split-row" style="color:#e74c3c; padding:0;">&times;</button>
            </div>`);
    }

    $(document).on('click', '.add-split-row', addSplitRow);
    $(document).on('click', '.remove-split-row', function() { $(this).closest('.split-row').remove(); updateRemaining(); });
    $(document).on('input', '.split-amount-input', updateRemaining);

    function updateRemaining() {
        const target = parseFloat($('#modal-target-amount').val());
        let allocated = 0;
        $('.split-amount-input').each(function() { allocated += parseFloat($(this).val() || 0); });
        const remaining = target - allocated;
        const display = Math.abs(remaining) < 0.0001 ? "0.00" : remaining.toFixed(4);
        $('#modal-remaining-display').text('$' + display)
            .css('color', Math.abs(remaining) < 0.0001 ? '#27ae60' : '#e74c3c');
    }

    $('#splitForm').submit(function(e) {
        e.preventDefault();
        const target    = parseFloat($('#modal-target-amount').val());
        const bankTxId  = $('#modal-bank-tx-id').val();
        let allocated   = 0;
        const splits    = [];

        $('.split-row').each(function() {
            const accId = $(this).find('select').val();
            const amt   = parseFloat($(this).find('input').val() || 0);
            if (accId && amt) { splits.push({ account_id: accId, amount: amt }); allocated += amt; }
        });

        if (Math.abs(target - allocated) > 0.0001) {
            alert('Balance mismatch. Difference: ' + (target - allocated).toFixed(4));
            return;
        }

        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiSplitCategorize']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { bank_transaction_id: bankTxId, splits: splits },
            success: function(res) {
                if (res.success) {
                    $('#splitModal').fadeOut();
                    const rowNode = document.getElementById('row-' + bankTxId);
                    if (rowNode) dt.row(rowNode).remove().draw(false);
                } else { alert('Error: ' + res.message); }
            },
            error: function() { alert('Splitting failed.'); }
        });
    });

    // ─── Unreconcile ───────────────────────────────────────────────────────────
    $(document).on('click', '.unreconcile-btn', function() {
        const id = $(this).data('id');
        const btn = $(this);
        if (!confirm('This will delete the corresponding ledger entries and move this transaction back to the dashboard. Proceed?')) return;
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ...');
        
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiUnreconcile']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    location.reload(); 
                } else {
                    alert('Error: ' + res.message);
                    btn.prop('disabled', false).html('<i class="fas fa-undo"></i> UNDO');
                }
            },
            error: function() {
                alert('Connection failed. Please check your network.');
                btn.prop('disabled', false).html('<i class="fas fa-undo"></i> UNDO');
            }
        });
    });
});
</script>
<?php $this->end(); ?>

