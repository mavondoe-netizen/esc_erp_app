<?php
/**
 * @var \App\View\AppView $this
 * @var string $tableName
 * @var array $existingFields
 */
$this->assign('title', 'Schema Builder - ' . h($tableName));
?>

<style>
    :root {
        --accent-color: #4f46e5;
        --accent-hover: #4338ca;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
    }
    
    .builder-layout {
        display: grid;
        grid-template-columns: 280px 1fr 320px;
        gap: 1.5rem;
        margin-top: 1rem;
        align-items: start;
    }

    .panel {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        max-height: 80vh;
    }

    .panel-header {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-light);
        border-radius: 12px 12px 0 0;
    }

    .panel-header h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .panel-body {
        padding: 1rem;
        overflow-y: auto;
        flex-grow: 1;
    }

    /* Palette Items */
    .type-item {
        background: white;
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        border-radius: 8px;
        cursor: grab;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.2s;
        font-weight: 500;
        color: #475569;
    }

    .type-item:hover {
        border-color: var(--accent-color);
        background: #f5f3ff;
        transform: translateY(-1px);
    }

    .type-item i {
        color: var(--accent-color);
        font-size: 1.1rem;
    }

    /* Drop Zone Items */
    .drop-zone {
        min-height: 300px;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 1rem;
        background: #f1f5f9;
        transition: background 0.3s;
    }

    .drop-zone.active {
        background: #e0e7ff;
        border-color: var(--accent-color);
    }

    .new-field-card {
        background: white;
        border: 1px solid var(--border-color);
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1rem;
        position: relative;
    }

    .new-field-card .remove-btn {
        color: #ef4444;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.25rem;
    }

    .field-type-badge {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        background: #ede9fe;
        color: #5b21b6;
        text-transform: uppercase;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    /* Existing Fields */
    .existing-field-item {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    .existing-field-item .name { font-weight: 600; color: #334155; }
    .existing-field-item .type { color: #94a3b8; font-family: monospace; }

    .sticky-actions {
        margin-top: 2rem;
        padding: 1.5rem;
        background: white;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        border-radius: 0 0 12px 12px;
    }

    .ghost {
        opacity: 0.4;
        background: #c8ebfb;
    }
</style>

<div class="dashboard-header" style="margin-bottom: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: var(--accent-color); font-weight: 800; margin: 0; letter-spacing: -0.025em;">
                Builder: <span style="color: #1e293b;"><?= h($tableName) ?></span>
            </h2>
            <p style="color: #64748b; margin-top: 0.25rem;">Drag fields from the palette to define your model's schema.</p>
        </div>
        <?= $this->Html->link('Back to Table List', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
    </div>
</div>

<div class="builder-layout">
    <!-- Palette -->
    <div class="panel">
        <div class="panel-header">
            <h4>Field Palette</h4>
        </div>
        <div class="panel-body" id="palette">
            <div class="type-item" data-type="string">
                <i class="fas fa-font"></i> Short Text (String)
            </div>
            <div class="type-item" data-type="text">
                <i class="fas fa-align-left"></i> Long Paragraph (Text)
            </div>
            <div class="type-item" data-type="int">
                <i class="fas fa-hashtag"></i> Number (Integer)
            </div>
            <div class="type-item" data-type="decimal">
                <i class="fas fa-dollar-sign"></i> Decimal / Currency
            </div>
            <div class="type-item" data-type="boolean">
                <i class="fas fa-check-square"></i> True/False (Boolean)
            </div>
            <div class="type-item" data-type="date">
                <i class="fas fa-calendar"></i> Date
            </div>
            <div class="type-item" data-type="datetime">
                <i class="fas fa-clock"></i> Date & Time
            </div>
        </div>
    </div>

    <!-- Drop Zone -->
    <div class="panel" style="grid-column: span 1;">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h4>New Model Schema</h4>
            <span id="field-count" class="badge" style="background: var(--accent-color);">0 Fields</span>
        </div>
        <div class="panel-body">
            <form id="schema-form" method="POST">
                <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
                <div id="drop-zone" class="drop-zone">
                    <!-- Dropped items will appear here -->
                    <div id="empty-state" style="text-align: center; color: #94a3b8; margin-top: 100px;">
                        <i class="fas fa-file-import" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p>Drag field types here to start building</p>
                    </div>
                </div>
                
                <div class="sticky-actions">
                    <button type="submit" class="btn btn-primary" id="save-btn" disabled>
                        <i class="fas fa-save" style="margin-right: 0.5rem;"></i> Save & Re-bake Model
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Existing Fields -->
    <div class="panel">
        <div class="panel-header">
            <h4>Existing Database Columns</h4>
        </div>
        <div class="panel-body">
            <?php foreach ($existingFields as $f): ?>
                <div class="existing-field-item">
                    <div class="name"><?= h($f['name']) ?></div>
                    <div class="type"><?= h($f['type']) ?></div>
                </div>
            <?php endforeach; ?>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: #94a3b8; font-style: italic;">
                System standard fields: id, created, modified are managed automatically.
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const palette = document.getElementById('palette');
    const dropZone = document.getElementById('drop-zone');
    const emptyState = document.getElementById('empty-state');
    const fieldCountBadge = document.getElementById('field-count');
    const saveBtn = document.getElementById('save-btn');
    let fieldIndex = 0;

    // Palette Sortable (Clones items)
    new Sortable(palette, {
        group: {
            name: 'schema',
            pull: 'clone',
            put: false
        },
        sort: false,
        animation: 150
    });

    // Drop Zone Sortable
    new Sortable(dropZone, {
        group: 'schema',
        animation: 150,
        ghostClass: 'ghost',
        onAdd: function(evt) {
            const type = evt.item.dataset.type;
            const originalText = evt.item.innerText.trim();
            
            // Remove the palette copy
            evt.item.remove();
            
            // Add a proper field card
            addFieldCard(type, originalText);
            updateUI();
        },
        onEnd: function() {
            // Re-indexing if reordered (though for ALTER TABLE it doesn't matter much)
        }
    });

    function addFieldCard(type, typeLabel) {
        fieldIndex++;
        const card = document.createElement('div');
        card.className = 'new-field-card';
        card.innerHTML = `
            <div>
                <span class="field-type-badge">${typeLabel}</span>
                <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                <div class="form-group">
                    <input type="text" name="fields[${fieldIndex}][name]" 
                           class="form-control" placeholder="field_name (lowercase_only)" 
                           required pattern="[a-z_]+" title="Lowercase letters and underscores only">
                </div>
            </div>
            <div class="remove-btn" title="Remove Field">
                <i class="fas fa-times-circle"></i>
            </div>
        `;
        
        card.querySelector('.remove-btn').addEventListener('click', () => {
            card.remove();
            updateUI();
        });
        
        dropZone.appendChild(card);
    }

    function updateUI() {
        const count = dropZone.querySelectorAll('.new-field-card').length;
        emptyState.style.display = count > 0 ? 'none' : 'block';
        fieldCountBadge.innerText = count + ' Fields';
        saveBtn.disabled = count === 0;
    }
});
</script>
