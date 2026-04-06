<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'ESCerp App - Premium ERP';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    
    <?= $this->Html->meta('icon') ?>
    
    <!-- Premium Design System -->
    <!-- Premium Design System -->
    <?= $this->Html->css(['premium', 'bulk_actions', 'sales_bot']) ?>

    <!-- DataTables & Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <?php if (!empty($sandboxModeActive)): ?>
    <div style="background:linear-gradient(90deg,#f59e0b,#d97706); color:white; padding:8px 1.5rem; display:flex; align-items:center; gap:0.75rem; font-weight:700; font-size:0.9rem; position:sticky; top:0; z-index:9999; box-shadow:0 2px 8px rgba(217,119,6,0.5);">
        <i class="fa fa-flask"></i>
        ⚠ SANDBOX MODE ACTIVE — You are working with test data. Production is unaffected.
        <a href="/sandbox" style="margin-left:auto; color:white; background:rgba(0,0,0,0.15); padding:3px 14px; border-radius:20px; text-decoration:none; font-size:0.8rem;">Manage Sandbox</a>
    </div>
    <?php endif; ?>

    <?php if (!empty($isSuperAdmin) && !empty($switchedCompanyId)): ?>
    <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); color:white; padding:8px 1.5rem; display:flex; align-items:center; gap:0.75rem; font-weight:700; font-size:0.9rem; position:sticky; top:0; z-index:9998; box-shadow:0 2px 8px rgba(99,102,241,0.4);">
        <i class="fa fa-building"></i>
        👁 VIEWING AS: <em style="font-style:normal; background:rgba(255,255,255,0.2); padding:1px 10px; border-radius:20px;"><?= h($switchedCompanyName ?? 'Company #' . $switchedCompanyId) ?></em>
        <?= $this->Form->create(null, ['url' => '/users/exit-company-switch', 'style' => 'margin-left:auto; display:inline;']) ?>
            <?= $this->Form->button('✕ Exit Company View', ['style' => 'background:rgba(255,255,255,0.2); color:white; border:none; padding:3px 14px; border-radius:20px; cursor:pointer; font-weight:700; font-size:0.8rem;']) ?>
        <?= $this->Form->end() ?>
    </div>
    <?php endif; ?>

    <div class="app-container">
        <!-- Top Navbar -->
        <header class="app-navbar">
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <?php if ($this->request->getAttribute('identity')): ?>
                    <?= $this->Html->link('<i class="fa fa-sign-out-alt"></i>', ['controller' => 'Users', 'action' => 'logout'], [
                        'escape' => false, 
                        'class' => 'logout-btn',
                        'title' => 'Logout'
                    ]) ?>
                <?php endif; ?>
                <div class="navbar-brand">
                    <a href="/">ESCerp_app</a>
                </div>
            </div>
            <div class="navbar-search">
                <form method="get" action="/search" style="margin: 0; display: flex; gap: 0.5rem;">
                    <input type="search" name="q" placeholder="Search everywhere..." aria-label="Search" style="margin: 0; width: 250px;">
                    <button type="submit" class="btn btn-primary" style="margin: 0;">Search</button>
                </form>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem; margin-left:auto; padding-right:0;">
                <?php if (!empty($isSuperAdmin)): ?>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <?= $this->Form->create(null, ['url' => '/users/switch-company', 'style' => 'display:flex; align-items:center; gap:0.5rem;']) ?>
                        <label for="company-switcher" style="color:#64748b; font-size:0.82rem; white-space:nowrap; font-weight:600;">
                            <i class="fa fa-building"></i> View as:
                        </label>
                        <select id="company-switcher" name="company_id" class="no-s2" onchange="this.form.submit()"
                            style="padding:0.35rem 0.75rem; border-radius:8px; border:1.5px solid #e2e8f0; font-size:0.82rem; background:#f8fafc; cursor:pointer; min-width:160px;">
                            <option value="">— My Company —</option>
                            <?php foreach ($allCompanies as $co): ?>
                            <?php
                                $coId   = is_array($co) ? ($co['id']   ?? '') : $co->id;
                                $coName = is_array($co) ? ($co['name'] ?? '') : $co->name;
                            ?>
                            <option value="<?= h($coId) ?>" <?= ($switchedCompanyId == $coId) ? 'selected' : '' ?>>
                                <?= h($coName) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    <?= $this->Form->end() ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($isAdminOrSuper)): ?>
                <a href="/sandbox" title="Sandbox Environment" style="color:#64748b; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:0.35rem;">
                    <i class="fa fa-flask"></i> Sandbox
                </a>
                <?php endif; ?>
            </div>
        </header>

        <div class="app-body">
            <!-- Sidebar -->
            <aside class="app-sidebar">
                <div class="sidebar-heading">Navigation</div>
                <ul class="nav-menu">
                    <li class="nav-item"><?= $this->Html->link('Dashboard', '/Dashboard', ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('Bank Reconciliation', ['controller' => 'BankTransactions', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('ZIMRA Tax Return', ['controller' => 'ZimraReports', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('Estimates', ['controller' => 'Estimates', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('Debit Notes', ['controller' => 'DebitNotes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('Credit Notes', ['controller' => 'CreditNotes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Database Backups'), ['controller' => 'Backups', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Exchange Rates'), ['controller' => 'ExchangeRates', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <?php if (!empty($isAdminOrSuper)): ?>
                    <li class="nav-item"><a href="/sandbox" class="nav-link" style="display:flex; align-items:center; gap:0.4rem;">
                            <i class="fa fa-flask"></i> Sandbox
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="/transactions/bulk-add" class="nav-link" style="display:flex; align-items:center; gap:0.4rem;">
                            <i class="fas fa-book-open"></i> Post Bulk Journals
                        </a>
                    </li>
                    <?php
                    $identity = $this->request->getAttribute('identity');
                    if ($identity && !empty($identity->employee_id)):
                    ?>
                    <li class="nav-item">
                        <a href="/portal/dashboard" class="nav-link" style="display:flex; align-items:center; gap:0.4rem;">
                            <i class="fa fa-id-card-clip"></i> My Portal
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul>
                    <?= $this->cell('Navigation') ?>
                </ul>
            </aside>

            <!-- Main Content Area -->
            <main class="app-content">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </main>
        </div>
    </div>

    <!-- Floating Bulk Action Bar -->
    <div id="bulk-action-bar" class="bulk-action-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-layer-group"></i>
            <span class="bulk-count">0</span> items selected
        </div>
        <div class="bulk-actions-btns">
            <button id="bulk-edit-btn" class="bulk-btn">
                <i class="fas fa-edit"></i> Bulk Set Value
            </button>
            <button id="bulk-delete-btn" class="bulk-btn danger">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
        <button id="bulk-close-btn" class="button button-clear" style="color: white; margin: 0; padding: 5px;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Bulk Update Modal -->
    <div id="bulk-update-modal" class="bulk-modal-overlay">
        <div class="bulk-modal">
            <h3><i class="fas fa-edit"></i> Bulk Set Value</h3>
            <p>Apply a new value to all selected records.</p>
            <div class="bulk-field-group">
                <label>Target Field</label>
                <select id="bulk-field-select">
                    <option value="">Loading updatable fields...</option>
                </select>
            </div>
            <div class="bulk-field-group" id="bulk-value-container">
                <label>New Value</label>
                <input type="text" id="bulk-value-input" placeholder="Enter new value">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button id="bulk-cancel-modal" class="button button-outline">Cancel</button>
                <button id="bulk-confirm-update" class="button">Apply to All</button>
            </div>
        </div>
    </div>

    <!-- jQuery, DataTables, & Buttons JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?= $this->fetch('script') ?>
    
    <!-- Global Bulk & DataTables Logic -->
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrfToken"]').attr('content');
            
            // Initialize Select2 on selects unless they opt-out
            $('select:not(.no-s2)').each(function() {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).attr('placeholder') || 'Select an option',
                    allowClear: true
                });
            });

            // Build correct controller base URL for both root and subdirectory installs
            const appBase = '<?= rtrim($this->Url->build('/'), '/') ?>';
            const pathParts = window.location.pathname.replace(appBase, '').split('/').filter(p => p !== '');
            const controllerUrl = appBase + (pathParts.length > 0 ? '/' + pathParts[0] : '');
            
            // 1. Initialize Datatables with custom settings
            let table = $('table:has(thead):not(.no-dt)').DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                order: [], // Default no initial sort to preserve logical order
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                    {
                        text: 'Import CSV',
                        action: function ( e, dt, node, config ) { $('#global-import-input').click(); }
                    }
                ]
            });

            // 2. Selection Logic
            const bulkBar = $('#bulk-action-bar');
            const bulkCount = $('.bulk-count');
            
            function updateSelectionStatus() {
                const selected = $('.row-checkbox:checked');
                bulkCount.text(selected.length);
                if (selected.length > 0) bulkBar.addClass('active');
                else bulkBar.removeClass('active');
            }

            $(document).on('change', '.row-checkbox', function() {
                $(this).closest('tr').toggleClass('selected', this.checked);
                updateSelectionStatus();
            });

            $(document).on('change', '#select-all-rows', function() {
                $('.row-checkbox').prop('checked', this.checked).trigger('change');
            });

            $('#bulk-close-btn').click(function() {
                $('.row-checkbox').prop('checked', false).trigger('change');
            });

            // 3. Bulk Delete
            $('#bulk-delete-btn').click(function() {
                const selectedIds = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
                if (!confirm(`Are you sure you want to delete ${selectedIds.length} selected records?`)) return;

                $.ajax({
                    url: controllerUrl + '/bulk-action',
                    type: 'POST',
                    data: { ids: selectedIds, action: 'delete' },
                    headers: { 'X-CSRF-Token': csrfToken },
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            window.location.reload();
                        } else alert('Error: ' + res.message);
                    }
                });
            });

            // 4. Bulk Edit Modal Loading
            let bulkUpdatableFields = [];
            $('#bulk-edit-btn').click(function() {
                $('#bulk-update-modal').css('display', 'flex');
                
                // Fetch fields only once per page load
                if ($('#bulk-field-select').children().length <= 1) {
                    $.get(controllerUrl + '/api-get-bulk-options', function(res) {
                        if (res.success) {
                            bulkUpdatableFields = res.fields;
                            const select = $('#bulk-field-select').html('<option value="">-- Select Field --</option>');
                            res.fields.forEach(f => {
                                select.append(`<option value="${f.field}">${f.label}</option>`);
                            });
                        }
                    });
                }
            });

            $('#bulk-cancel-modal').click(function() { $('#bulk-update-modal').hide(); });

            // Handle Value Input Type based on field type
            $('#bulk-field-select').change(function() {
                const fieldName = $(this).val();
                const field = bulkUpdatableFields.find(f => f.field === fieldName);
                if (!field) return;

                const container = $('#bulk-value-container').html(`<label>New Value for ${field.label}</label>`);
                
                if (field.type === 'boolean') {
                    container.append(`<select id="bulk-value-input">
                        <option value="1">YES / True</option>
                        <option value="0">NO / False</option>
                    </select>`);
                } else if (field.type === 'date') {
                    container.append(`<input type="date" id="bulk-value-input">`);
                } else if (field.type === 'decimal' || field.type === 'integer') {
                    container.append(`<input type="number" id="bulk-value-input" step="any">`);
                } else {
                    container.append(`<input type="text" id="bulk-value-input" placeholder="Enter new value">`);
                }
            });

            // 5. Bulk Update Submission
            $('#bulk-confirm-update').click(function() {
                const selectedIds = $('.row-checkbox:checked').map(function() { return $(this).val(); }).get();
                const field = $('#bulk-field-select').val();
                const value = $('#bulk-value-input').val();

                if (!field) return alert('Please select a field to update.');
                if (!confirm(`Apply this change to ${selectedIds.length} records?`)) return;

                $.ajax({
                    url: controllerUrl + '/bulk-action',
                    type: 'POST',
                    data: { ids: selectedIds, action: 'update', field: field, value: value },
                    headers: { 'X-CSRF-Token': csrfToken },
                    success: function(res) {
                        if (res.success) {
                            alert(res.message);
                            window.location.reload();
                        } else alert('Error: ' + res.message);
                    }
                });
            });

            // Handle the hidden generic CSV import input
            $('#global-import-input').on('change', function() {
                if (this.files.length > 0 && controllerUrl !== '') {
                    if(!confirm('Are you sure you want to import data into ' + controllerUrl + '?')) return;
                    
                    let formData = new FormData();
                    formData.append('import_file', this.files[0]);
                    
                    $.ajax({
                        url: controllerUrl + '/import',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: { 'X-CSRF-Token': csrfToken },
                        success: function(response) {
                            alert('Import successful! Page will refresh.');
                            window.location.reload();
                        },
                        error: function(xhr) {
                            alert('Import failed: ' + (xhr.responseJSON?.message || 'Check server logs'));
                        }
                    });
                }
            });
        });
    </script>

    <!-- Hidden Generic Import Form -->
    <input type="file" id="global-import-input" accept=".csv" style="display: none;">

    <!-- Interactive Sales Bot Widget -->
    <div class="sales-bot-container">
        <div id="sales-bot-bubble" class="sales-bot-bubble">
            <i class="fas fa-comment-dots"></i>
        </div>
        <div id="sales-bot-window" class="sales-bot-window">
            <div class="sales-bot-header">
                <h4><i class="fas fa-robot"></i> ESCerp Assistant</h4>
                <div id="sales-bot-close" style="cursor:pointer; font-size: 1.2em;">&times;</div>
            </div>
            <div id="sales-bot-messages" class="sales-bot-messages">
                <!-- Messages populate here -->
                <div id="bot-typing" class="bot-typing">Assistant is typing...</div>
            </div>
            <div class="sales-bot-input-area">
                <input type="text" id="sales-bot-input" placeholder="Type a message..." autocomplete="off">
                <button id="sales-bot-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bot logic -->
    <?= $this->Html->script('sales_bot') ?>
</body>
</html>
