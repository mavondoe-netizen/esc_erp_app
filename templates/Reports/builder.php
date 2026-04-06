<?php
/**
 * @var \App\View\AppView $this
 * @var array $tableOptions
 */
$this->assign('title', 'Entity Agnostic Report Builder');
?>
<style>
    .builder-container { display: flex; gap: 20px; margin-top: 20px; }
    .col-box { flex: 1; background: #fdfdfd; border: 2px dashed #ccc; border-radius: 6px; padding: 15px; min-height: 200px; }
    .col-box h4 { margin-top: 0; color: #555; border-bottom: 1px solid #eee; padding-bottom: 10px; font-size: 1.1em; }
    .draggable-item { 
        background: #fff; border: 1px solid #ddd; padding: 8px 15px; margin-bottom: 8px; 
        border-radius: 4px; cursor: grab; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        display: flex; align-items: center; justify-content: space-between;
    }
    .draggable-item:active { cursor: grabbing; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .filters { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    #dynamicResultTable { margin-top: 30px; width: 100%; }
    #dynamicResultTable th { background: #eef; }
    .loading-overlay { display: none; opacity: 0.7; pointer-events: none; }
</style>

<!-- Load SortableJS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<div class="reports index content">
    <h3><?= __('Drag and Drop Report Generator') ?></h3>
    <p class="text-muted">Select an entity, drag columns to the Selected box, and instantly generate a dynamic data report.</p>

    <div class="filters">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label>Target Entity (Table)</label>
                <?= $this->Form->select('target_table', $tableOptions, [
                    'empty' => 'Choose a module...', 
                    'id' => 'targetTableSelect',
                    'class' => 'form-select'
                ]) ?>
            </div>
            <div class="col-md-3">
                <label>Filter Start Date (Optional)</label>
                <input type="date" id="filterStartDate" class="form-control" />
            </div>
            <div class="col-md-3">
                <label>Filter End Date (Optional)</label>
                <input type="date" id="filterEndDate" class="form-control" />
            </div>
            <div class="col-md-2" style="margin-top:25px;">
                <button id="generateBtn" class="button button-outline" disabled>Generate</button>
            </div>
        </div>
    </div>

    <!-- Drag and Drop Zones -->
    <div class="row">
        <div class="col-md-3">
            <div class="col-box" id="associationsBox" style="display:none; margin-bottom: 20px; min-height: auto;">
                <h4>Join Associations</h4>
                <div id="associationsList" class="list-group">
                    <!-- Associations will load here -->
                </div>
            </div>
            
            <div class="col-box" id="availableColumnsBox">
                <h4>Available Variables</h4>
                <div id="availableColumnsList" style="min-height: 150px;">
                    <p class="text-muted" style="text-align:center; margin-top:30px;">Select an entity first...</p>
                </div>
            </div>
        </div>

        <div class="col-md-1" style="display:flex; align-items:center; justify-content:center; color:#ccc; font-size:1.5em; padding-top: 100px;">
            <i class="fas fa-arrow-right"></i>
        </div>

        <div class="col-md-8">
            <div class="builder-container" id="builderZones" style="opacity: 0.5; pointer-events: none; margin-top: 0;">
                <div class="col-box" id="selectedColumnsBox" style="border-color: #38761d; background: #fbfdf7; width: 100%;">
                    <h4 style="color:#38761d;">Selected Report Columns</h4>
                    <div id="selectedColumnsList" style="min-height: 250px;">
                        <!-- Drag items here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div id="reportOutputContainer" style="display:none;">
        <hr style="margin-top: 40px;" />
        <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 id="reportTitle" style="margin:0;">Report Output</h4>
            <div class="btn-group">
                <button onclick="exportToCSV()" class="button button-outline">Export CSV</button>
                <button onclick="window.print()" class="button button-clear">Print</button>
            </div>
        </div>
        <div class="table-responsive" style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid #eee;">
            <table class="table table-bordered table-striped no-dt" id="dynamicResultTable" style="margin:0;">
                <thead id="dynamicTableHeader"></thead>
                <tbody id="dynamicTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const csrfToken = <?= json_encode($this->request->getAttribute('csrfToken')) ?>;
    const fetchUrl = `<?= $this->Url->build(['action' => 'apiFetchColumns']) ?>`;
    
    // Initialize SortableJS
    new Sortable(document.getElementById('availableColumnsList'), {
        group: {
            name: 'shared',
            pull: 'clone'
        }, 
        animation: 150,
        sort: false,
        ghostClass: 'sortable-ghost'
    });

    new Sortable(document.getElementById('selectedColumnsList'), {
        group: 'shared',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onAdd: function(evt) {
            checkGenerateReady();
        },
        onRemove: function(evt) {
            checkGenerateReady();
            if (evt.from.id === 'selectedColumnsList') {
                evt.item.remove(); // Remove items dragged back out
            }
        }
    });

    const targetSelect = document.getElementById('targetTableSelect');
    const assocBox = document.getElementById('associationsBox');
    const assocList = document.getElementById('associationsList');
    const availList = document.getElementById('availableColumnsList');
    const selList = document.getElementById('selectedColumnsList');
    const genBtn = document.getElementById('generateBtn');
    const zones = document.getElementById('builderZones');
    const thead = document.getElementById('dynamicTableHeader');
    const tbody = document.getElementById('dynamicTableBody');
    const outContainer = document.getElementById('reportOutputContainer');

    function checkGenerateReady() {
        if (targetSelect.value && selList.children.length > 0) {
            genBtn.removeAttribute('disabled');
        } else {
            genBtn.setAttribute('disabled', 'true');
        }
    }

    targetSelect.addEventListener('change', function() {
        const table = this.value;
        availList.innerHTML = '';
        selList.innerHTML = '';
        assocList.innerHTML = '';
        assocBox.style.display = 'none';
        outContainer.style.display = 'none';

        if (!table) {
            zones.style.opacity = '0.5';
            zones.style.pointerEvents = 'none';
            checkGenerateReady();
            return;
        }

        zones.style.opacity = '1';
        zones.style.pointerEvents = 'auto';
        availList.innerHTML = '<p>Loading schema...</p>';

        fetch(`${fetchUrl}?table=${encodeURIComponent(table)}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            availList.innerHTML = '';
            if(data.success) {
                // Render columns
                data.columns.forEach(col => addDraggableItem(col, col, availList));
                
                // Render associations
                if (data.associations && data.associations.length > 0) {
                    assocBox.style.display = 'block';
                    data.associations.forEach(assoc => {
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-sm btn-outline-secondary mb-1 w-100 text-start';
                        btn.style.fontSize = '0.8rem';
                        btn.innerHTML = `<i class="fas fa-plus-circle"></i> Join ${assoc.name}`;
                        btn.onclick = () => loadAssociationColumns(table, assoc.name);
                        assocList.appendChild(btn);
                    });
                }
            } else {
                availList.innerHTML = `<p style="color:red;">Error: ${data.message}</p>`;
            }
        });
    });

    function loadAssociationColumns(primaryTable, associationName) {
        const loadingItem = document.createElement('div');
        loadingItem.className = 'text-muted sm';
        loadingItem.innerText = `Loading ${associationName}...`;
        availList.appendChild(loadingItem);

        fetch(`${fetchUrl}?table=${encodeURIComponent(primaryTable)}&association=${encodeURIComponent(associationName)}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            loadingItem.remove();
            if (data.success) {
                data.columns.forEach(col => {
                    const fullId = `${data.prefix}.${col}`;
                    addDraggableItem(fullId, fullId, availList);
                });
            } else {
                alert('Error loading association: ' + data.message);
            }
        });
    }

    function addDraggableItem(id, label, container) {
        const el = document.createElement('div');
        el.className = 'draggable-item';
        el.dataset.id = id;
        el.innerHTML = `<span><strong>${label}</strong></span> <span style="color:#aaa;">&#10021;</span>`;
        container.appendChild(el);
    }

    genBtn.addEventListener('click', function() {
        const table = targetSelect.value;
        const selectedEls = selList.querySelectorAll('.draggable-item');
        const columns = Array.from(selectedEls).map(el => el.dataset.id);
        const start = document.getElementById('filterStartDate').value;
        const end = document.getElementById('filterEndDate').value;

        if (columns.length === 0) return alert('Select at least 1 column.');

        genBtn.innerText = 'Building...';
        genBtn.setAttribute('disabled', 'true');

        fetch(`<?= $this->Url->build(['action' => 'apiGenerateReport']) ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ table: table, columns: columns, start_date: start, end_date: end })
        })
        .then(res => res.json())
        .then(data => {
            genBtn.innerText = 'Generate';
            genBtn.removeAttribute('disabled');
            
            if (data.success) {
                renderTable(columns, data.data);
            } else {
                alert('Generation Error: ' + data.message);
            }
        })
        .catch(err => {
            genBtn.innerText = 'Generate';
            genBtn.removeAttribute('disabled');
            alert('Fatal Network Error.');
        });
    });

    function renderTable(columns, rows) {
        outContainer.style.display = 'block';
        
        // Build Head
        let theadHtml = '<tr>';
        columns.forEach(c => {
            theadHtml += `<th>${c.toUpperCase().replace('.', ' ')}</th>`;
        });
        theadHtml += '</tr>';
        thead.innerHTML = theadHtml;

        // Build Body
        let tbodyHtml = '';
        if (rows.length === 0) {
            tbodyHtml = `<tr><td colspan="${columns.length}" class="text-center">No records found.</td></tr>`;
        } else {
            rows.forEach(row => {
                tbodyHtml += '<tr>';
                columns.forEach(c => {
                    let val = getNestedValue(row, c);
                    if (val === null || val === undefined) val = '-';
                    if (typeof val === 'object') {
                        val = JSON.stringify(val);
                    }
                    tbodyHtml += `<td>${val}</td>`;
                });
                tbodyHtml += '</tr>';
            });
        }
        tbody.innerHTML = tbodyHtml;
        
        // Scroll to output
        outContainer.scrollIntoView({ behavior: 'smooth' });
    }

    function getNestedValue(obj, path) {
        if (!path.includes('.')) return obj[path];
        
        const parts = path.split('.');
        let current = obj;
        
        for (const part of parts) {
            // CakePHP ORM uses underscore or camelCase depending on conversion
            // Usually internal entities are underscore-named in JSON but could be camel
            let key = part.toLowerCase(); // simplified
            
            // Try to find the matching key in a case-insensitive way if possible, or just exact
            // CakePHP standard: Assoc name 'Employees' becomes 'employee' in single result
            // Let's try CamelCase and lowercase
            let actualKey = Object.keys(current).find(k => k.toLowerCase() === part.toLowerCase());
            
            if (actualKey && current[actualKey] !== undefined) {
                current = current[actualKey];
            } else {
                return null;
            }
        }
        return current;
    }
});

function exportToCSV() {
    let csv = [];
    const rows = document.querySelectorAll("#dynamicResultTable tr");
    
    for (const row of rows) {
        let cols = row.querySelectorAll("td, th");
        let csvRow = [];
        for (const col of cols) {
            csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
        }
        csv.push(csvRow.join(","));
    }
    
    const csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "esc_dynamic_report.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
});
</script>
