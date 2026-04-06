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

    <div class="row">
        <div class="column column-75">
            <div class="card" style="padding: 20px; border-radius: 12px; background: white; border: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0;"><i class="fas fa-list"></i> Raw Bank Statement Imports</h4>
                </div>
                <div class="table-responsive">
                    <table id="bank-tx-table" class="no-dt" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-rows"></th>
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
                            <tr id="row-<?= $tx->id ?>" class="<?= isset($tx->suggested_account_id) ? 'suggested-row' : '' ?>">
                                <td style="text-align: center;"><input type="checkbox" class="row-checkbox" value="<?= $tx->id ?>"></td>
                                <td><?= h($tx->date) ?></td>
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
                                            <select class="categorize-select" data-id="<?= $tx->id ?>" style="margin-bottom:0; padding:5px; font-size:0.85em; width:150px;">
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

    // Categorize / Match Action
    $('.match-btn').on('click', function() {
        const bankTxId = $(this).data('id');
        const select = $(`.categorize-select[data-id="${bankTxId}"]`);
        const accountId = select.val();
        const saveRule = $(`.save-rule-check[data-id="${bankTxId}"]`).is(':checked');
        const row = $(`#row-${bankTxId}`);

        if (!accountId) {
             alert('Please select an account first.');
             return;
        }

        $(this).prop('disabled', true);
        select.prop('disabled', true);
        
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiCategorize']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { 
                bank_transaction_id: bankTxId, 
                account_id: accountId,
                save_rule: saveRule ? 1 : 0
            },
            success: function(res) {
                if (res.success) {
                    row.css('background-color', '#d4edda').fadeOut(600, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Error: ' + res.message);
                    $(this).prop('disabled', false);
                    select.prop('disabled', false);
                }
            },
            error: function() {
                alert('Connection failed during categorization.');
                $(this).prop('disabled', false);
                select.prop('disabled', false);
            }
        });
    });

    // Split Logic
    $(document).on('click', '.split-btn', function() {
        console.log('Split button clicked for ID:', $(this).data('id'));
        const id = $(this).data('id');
        const rawAmount = parseFloat($(this).data('amount'));
        console.log('Raw amount:', rawAmount);
        const amount = Math.abs(rawAmount);
        
        $('#modal-bank-tx-id').val(id);
        $('#modal-target-amount').val(amount);
        // Show up to 4 decimals if they exist, otherwise 2
        const displayAmount = amount % 1 === 0 ? amount.toFixed(2) : amount.toString();
        $('#modal-total-display').text('$' + displayAmount);
        $('#split-rows-container').empty();
        
        addSplitRow();
        addSplitRow();
        updateRemaining();
        console.log('Showing modal #splitModal');
        $('#splitModal').fadeIn();
    });

    // Delete Logic
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $(`#row-${id}`);

        if (!confirm('Are you sure you want to delete this transaction from the import?')) {
            return;
        }

        $(this).prop('disabled', true);
        
        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiDelete']) ?>',
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { id: id },
            success: function(res) {
                if (res.success) {
                    row.fadeOut(600, function() { $(this).remove(); });
                } else {
                    alert('Error: ' + res.message);
                    $(this).prop('disabled', false);
                }
            },
            error: function() {
                alert('Delete failed. Please try again.');
                $(this).prop('disabled', false);
            }
        });
    });

    $('.close-modal').click(function() { $('#splitModal').fadeOut(); });

    function addSplitRow() {
        let optionsHtml = '<option value="">-- Choose Account --</option>';
        for (const [id, label] of Object.entries(accountOptions)) {
            optionsHtml += `<option value="${id}">${label}</option>`;
        }
        
        const html = `
            <div class="split-row" style="display:flex; gap:10px; margin-bottom:10px;">
                <select name="account_id" style="flex:2;" required>${optionsHtml}</select>
                <input type="number" name="amount" placeholder="Amount" step="any" style="flex:1;" class="split-amount-input" required>
                <button type="button" class="button button-clear remove-split-row" style="color:#e74c3c; padding:0;">&times;</button>
            </div>
        `;
        $('#split-rows-container').append(html);
    }

    $(document).on('click', '.add-split-row', addSplitRow);
    $(document).on('click', '.remove-split-row', function() { $(this).closest('.split-row').remove(); updateRemaining(); });
    $(document).on('input', '.split-amount-input', updateRemaining);

    function updateRemaining() {
        const target = parseFloat($('#modal-target-amount').val());
        let allocated = 0;
        $('.split-amount-input').each(function() {
            allocated += parseFloat($(this).val() || 0);
        });
        const remaining = target - allocated;
        // Show precision if remaining is very small but not zero
        const displayRemaining = Math.abs(remaining) < 0.0001 ? "0.00" : remaining.toFixed(4);
        $('#modal-remaining-display').text('$' + displayRemaining);
        $('#modal-remaining-display').css('color', Math.abs(remaining) < 0.0001 ? '#27ae60' : '#e74c3c');
    }

    $('#splitForm').submit(function(e) {
        e.preventDefault();
        const target = parseFloat($('#modal-target-amount').val());
        const bankTxId = $('#modal-bank-tx-id').val();
        let allocated = 0;
        const splits = [];

        $('.split-row').each(function() {
            const accId = $(this).find('select').val();
            const amt = parseFloat($(this).find('input').val() || 0);
            if (accId && amt) {
                splits.push({ account_id: accId, amount: amt });
                allocated += amt;
            }
        });

        if (Math.abs(target - allocated) > 0.0001) {
            alert('Balance mismatch. Please allocate the full transaction amount. Difference: ' + (target - allocated).toFixed(4));
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
                    $(`#row-${bankTxId}`).css('background-color', '#d1ecf1').fadeOut(600, function() { $(this).remove(); });
                } else { alert('Error: ' + res.message); }
            },
            error: function() { alert('Splitting failed.'); }
        });
    });
});
</script>
<?php $this->end(); ?>
