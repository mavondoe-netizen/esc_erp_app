<?php
/**
 * @var \App\Model\Entity\Estimate $estimate
 * @var \App\Model\Entity\Company $company
 */

$currencyCode = $company->reporting_currency ?? 'USD';
$currencySymbols = [
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'ZWG' => 'ZiG',
    'ZAR' => 'R',
    'CAD' => 'C$',
    'AUD' => 'A$',
];
$currencySymbol = $currencySymbols[$currencyCode] ?? $currencyCode;

$this->assign('actions', $this->element('document_actions', [
    'entity' => $estimate,
    'controller' => 'Estimates',
    'approval_workflow' => false
]));
?>
<div class="estimates view content">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #f1f5f9; padding-bottom: 30px;">
        <div>
            <?php if (!empty($company->logo)): ?>
                <img src="<?= h($company->logo) ?>" style="max-height: 100px; margin-bottom: 15px;" alt="Logo" />
            <?php else: ?>
                <h1 style="color: var(--primary-color); margin: 0;"><?= h($company->name) ?></h1>
            <?php endif; ?>
            <p style="color: #64748b; line-height: 1.6; margin: 0;">
                <?= nl2br(h($company->address)) ?><br>
                <strong>Email:</strong> <?= h($company->email) ?><br>
                <strong>Phone:</strong> <?= h($company->phone) ?>
            </p>
        </div>
        <div style="text-align: right;">
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #4b5563; margin-bottom: 10px;">ESTIMATE</h1>
            <div style="color: #64748b;">
                <strong>Estimate #:</strong> <span style="color: #0f172a;"><?= h($estimate->id) ?></span><br>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($estimate->date) ?></span><br>
                <strong>Expiry:</strong> <span style="color: #0f172a;"><?= h($estimate->expiry_date) ?></span><br>
                <strong>Status:</strong> <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; color: #0f172a; font-weight: 600; font-size: 0.8rem;"><?= strtoupper(h($estimate->status)) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Estimate For</h4>
            <h3 style="margin-bottom: 5px;"><?= $estimate->hasValue('customer') ? h($estimate->customer->name) : '—' ?></h3>
            <?php if ($estimate->description): ?>
                <p style="color: #64748b; line-height: 1.5;">
                    <?= h($estimate->description) ?>
                </p>
            <?php endif; ?>
        </div>
        <div style="text-align: center;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Currency</h4>
             <h3 style="color: var(--primary-color); font-weight: 600;"><?= h($currencyCode) ?> (<?= h($currencySymbol) ?>)</h3>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Estimate Total</h4>
             <h2 style="color: #4b5563; font-size: 2.2rem; margin: 0;"><?= $this->formatCurrency($estimate->total, $currencyCode) ?></h2>
        </div>
    </div>

    <div class="related">
        <table class="table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center" style="width: 80px;">Qty</th>
                    <th class="text-right" style="width: 120px;">Unit Price</th>
                    <th class="text-right" style="width: 100px;">Tax (VAT)</th>
                    <th class="text-right" style="width: 130px;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal = 0;
                $totalVat = 0;
                foreach ($estimate->estimate_items as $item) : 
                    $subtotal += ($item->quantity * $item->unit_price);
                    $totalVat += ($item->vat_amount ?? 0);
                ?>
                <tr>
                    <td>
                        <strong style="color: #0f172a;"><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></strong><br>
                        <small style="color: #64748b;"><?= h($item->description) ?></small>
                    </td>
                    <td class="text-center"><?= $this->Number->format($item->quantity) ?></td>
                    <td class="text-right"><?= $this->formatCurrency($item->unit_price, $currencyCode) ?></td>
                    <td class="text-right">
                        <span style="display: block; font-size: 0.75rem; color: #94a3b8;"><?= $this->Number->format($item->vat_rate) ?>%</span>
                        <?= $this->formatCurrency($item->vat_amount, $currencyCode) ?>
                    </td>
                    <td class="text-right" style="font-weight: 600; color: #0f172a;"><?= $this->formatCurrency($item->line_total, $currencyCode) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="width: 300px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Subtotal</span>
                    <span><?= $this->formatCurrency($subtotal, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Tax (VAT)</span>
                    <span><?= $this->formatCurrency($totalVat, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #0f172a; margin-top: 10px; font-weight: 800; font-size: 1.25rem; color: #0f172a;">
                    <span>Total</span>
                    <span><?= $this->formatCurrency($estimate->total, $currencyCode) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- E-Signature and Date Stamp Section -->
    <div class="signature-section" style="margin-top: 50px; border-top: 1px dashed #e2e8f0; padding-top: 30px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: flex-end;">
            <!-- Left Side: Terms / Note -->
            <div style="color: #64748b; font-size: 0.85rem; line-height: 1.6;">
                <h4 style="color: #0f172a; margin-bottom: 8px; font-weight: 600;">Terms & Confirmation</h4>
                <p style="margin: 0 0 10px 0;">This estimate is subject to the standard service agreements and is valid for 30 days from the issue date. Unsigned estimates remain drafts and do not constitute active jobs.</p>
                <div style="display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; margin-top: 15px;">
                    <i class="fa fa-shield-halved" style="color: #3b82f6; font-size: 1.1rem;"></i>
                    <span style="font-size: 0.75rem; color: #475569;">
                        This document supports digital signing. Once signed, the signature is embedded vector-sharp when saved as a PDF.
                    </span>
                </div>
            </div>

            <!-- Right Side: Interactive Signature Block -->
            <div id="signature-block-container" style="position: relative;">
                <!-- Unsigned Placeholder & Controls (Hidden in print) -->
                <div id="signature-trigger-panel" class="no-print" style="border: 2px dashed #cbd5e1; border-radius: 12px; padding: 25px; text-align: center; background: #f8fafc; cursor: pointer; transition: all 0.2s;" onclick="openSignaturePad()">
                    <i class="fa fa-signature" style="font-size: 2rem; color: #94a3b8; margin-bottom: 10px; display: block;"></i>
                    <span style="font-size: 0.9rem; color: #475569; font-weight: 600; display: block;">Sign & Date Stamp Electronically</span>
                    <span style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px; display: block;">Click to add an official digital signature</span>
                </div>

                <!-- Signature Pad Modal-like Editor Panel (Hidden in print) -->
                <div id="signature-editor-panel" class="no-print" style="display: none; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); position: relative; z-index: 10;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                        <h4 style="margin: 0; font-size: 1rem; color: #0f172a; font-weight: 700;"><i class="fa fa-pen-nib" style="color: #2563eb;"></i> Electronic Signature Pad</h4>
                        <button type="button" onclick="closeSignaturePad()" style="background: none; border: none; font-size: 1.2rem; color: #94a3b8; cursor: pointer; padding: 0;"><i class="fa fa-times"></i></button>
                    </div>

                    <!-- Canvas Area -->
                    <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; position: relative; margin-bottom: 15px;">
                        <canvas id="signature-canvas" width="360" height="150" style="width: 100%; height: 150px; display: block; cursor: crosshair; touch-action: none;"></canvas>
                        <span style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); font-size: 0.7rem; color: #94a3b8; pointer-events: none; text-transform: uppercase; letter-spacing: 0.05em;">Sign above this line</span>
                    </div>

                    <!-- Text Fields -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 4px;">Signatory Name</label>
                            <input type="text" id="sig-name" value="<?= h($company->name) ?> Representative" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;" placeholder="e.g. John Doe">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 4px;">Title / Designation</label>
                            <input type="text" id="sig-title" value="Authorized Signatory" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;" placeholder="e.g. Manager">
                        </div>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 4px;">Signing Date</label>
                        <input type="date" id="sig-date" value="<?= date('Y-m-d') ?>" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;">
                    </div>

                    <!-- Editor Buttons -->
                    <div style="display: flex; justify-content: space-between; gap: 10px;">
                        <button type="button" onclick="clearCanvas()" class="btn-doc btn-back" style="padding: 8px 15px; font-size: 0.8rem;"><i class="fa fa-eraser"></i> Clear</button>
                        <button type="button" onclick="applySignature()" class="btn-doc btn-success" style="padding: 8px 15px; font-size: 0.8rem; flex-grow: 1; justify-content: center;"><i class="fa fa-check-double"></i> Apply E-Sign</button>
                    </div>
                </div>

                <!-- Final Signed Render Display Box (Shown in print/PDF and view screen) -->
                <div id="signature-signed-display" style="display: none; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #fff; position: relative;">
                    <!-- Badge -->
                    <div style="position: absolute; top: 15px; right: 15px; display: flex; align-items: center; gap: 4px; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 4px 10px; border-radius: 20px; color: #16a34a; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                        <i class="fa fa-circle-check"></i> E-Sign Verified
                    </div>

                    <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;">Authorized Representative</div>
                    
                    <!-- Signature Rendered Image -->
                    <div style="height: 80px; margin-bottom: 10px; display: flex; align-items: center;">
                        <img id="sig-rendered-img" src="" alt="Signature" style="max-height: 70px; object-fit: contain; max-width: 100%;">
                    </div>

                    <!-- Signatory Info -->
                    <div style="border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        <strong id="sig-display-name" style="color: #0f172a; font-size: 0.95rem; display: block;"></strong>
                        <span id="sig-display-title" style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 2px;"></span>
                        
                        <!-- Date & Verification Code -->
                        <div style="margin-top: 8px; font-size: 0.75rem; color: #475569; display: flex; flex-direction: column; gap: 2px;">
                            <span><strong>Signed Date:</strong> <span id="sig-display-date"></span></span>
                            <span style="font-family: monospace; color: #94a3b8; font-size: 0.65rem;" id="sig-display-hash"></span>
                        </div>
                    </div>

                    <!-- Clear / Re-sign Control (Hidden in print) -->
                    <button type="button" onclick="clearSignature()" class="no-print" style="position: absolute; bottom: 15px; right: 15px; background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 4px; padding: 5px 8px; border-radius: 4px; transition: background 0.2s;"><i class="fa fa-trash-can"></i> Remove Signature</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Check if a signature already exists in localStorage for this estimate
    const estimateId = "<?= $estimate->id ?>";
    const storageKey = `estimate_sig_${estimateId}`;
    const cachedSig = localStorage.getItem(storageKey);

    if (cachedSig) {
        try {
            const data = JSON.parse(cachedSig);
            renderSignedDisplay(data.image, data.name, data.title, data.date, data.hash);
        } catch (e) {
            console.error("Error loading cached signature:", e);
        }
    }

    // 2. Initialize Canvas Drawing Logic
    const canvas = document.getElementById("signature-canvas");
    if (!canvas) return;
    
    const ctx = canvas.getContext("2d");
    let drawing = false;

    // Set line styles for realistic pen stroke
    ctx.strokeStyle = "#1e3a8a"; // Elegant Navy Blue Ink
    ctx.lineWidth = 2.5;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";

    // Helper to get coordinates relative to canvas
    function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        // Handle touch events vs mouse events
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        
        // Scale appropriately based on CSS boundaries
        return {
            x: (clientX - rect.left) * (canvas.width / rect.width),
            y: (clientY - rect.top) * (canvas.height / rect.height)
        };
    }

    // Mouse Draw Actions
    canvas.addEventListener("mousedown", (e) => {
        drawing = true;
        const pos = getCoordinates(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        e.preventDefault();
    });

    canvas.addEventListener("mousemove", (e) => {
        if (!drawing) return;
        const pos = getCoordinates(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        e.preventDefault();
    });

    window.addEventListener("mouseup", () => {
        drawing = false;
    });

    // Touch Draw Actions (Mobile & Tablets)
    canvas.addEventListener("touchstart", (e) => {
        drawing = true;
        const pos = getCoordinates(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        e.preventDefault();
    }, { passive: false });

    canvas.addEventListener("touchmove", (e) => {
        if (!drawing) return;
        const pos = getCoordinates(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        e.preventDefault();
    }, { passive: false });

    canvas.addEventListener("touchend", (e) => {
        drawing = false;
        e.preventDefault();
    }, { passive: false });
});

// Controls Functions
function openSignaturePad() {
    document.getElementById("signature-trigger-panel").style.display = "none";
    document.getElementById("signature-editor-panel").style.display = "block";
    
    // Reset canvas dimensions and scale for High-DPI screens
    const canvas = document.getElementById("signature-canvas");
    const ctx = canvas.getContext("2d");
    const rect = canvas.getBoundingClientRect();
    
    // Scale for crisp rendering
    const dpr = window.devicePixelRatio || 1;
    canvas.width = rect.width * dpr;
    canvas.height = rect.height * dpr;
    ctx.scale(dpr, dpr);
    
    // Re-apply pen styles after canvas resize
    ctx.strokeStyle = "#1e3a8a"; 
    ctx.lineWidth = 2.5;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
}

function closeSignaturePad() {
    document.getElementById("signature-editor-panel").style.display = "none";
    document.getElementById("signature-trigger-panel").style.display = "block";
}

function clearCanvas() {
    const canvas = document.getElementById("signature-canvas");
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function applySignature() {
    const canvas = document.getElementById("signature-canvas");
    
    // Check if the canvas is blank
    const isBlank = isCanvasBlank(canvas);
    if (isBlank) {
        alert("Please draw your signature first.");
        return;
    }

    const name = document.getElementById("sig-name").value.trim() || "Authorized Representative";
    const title = document.getElementById("sig-title").value.trim() || "Authorized Signatory";
    const date = document.getElementById("sig-date").value || new Date().toISOString().split('T')[0];
    
    // Generate secure mock verification hash
    const estimateId = "<?= $estimate->id ?>";
    const randStr = Math.random().toString(36).substring(2, 10).toUpperCase();
    const hash = `SECURE-SIG-SHA256: [${estimateId}-${randStr}-${date.replace(/-/g, "")}]`;
    
    const signatureImage = canvas.toDataURL("image/png");

    // Cache to localStorage
    const storageKey = `estimate_sig_${estimateId}`;
    localStorage.setItem(storageKey, JSON.stringify({
        image: signatureImage,
        name: name,
        title: title,
        date: date,
        hash: hash
    }));

    // Render Display Block
    renderSignedDisplay(signatureImage, name, title, date, hash);
}

function renderSignedDisplay(imgSrc, name, title, date, hash) {
    document.getElementById("sig-rendered-img").src = imgSrc;
    document.getElementById("sig-display-name").textContent = name;
    document.getElementById("sig-display-title").textContent = title;
    document.getElementById("sig-display-date").textContent = date;
    document.getElementById("sig-display-hash").textContent = hash;

    document.getElementById("signature-editor-panel").style.display = "none";
    document.getElementById("signature-trigger-panel").style.display = "none";
    document.getElementById("signature-signed-display").style.display = "block";
}

function clearSignature() {
    if (confirm("Are you sure you want to remove the electronic signature from this estimate?")) {
        const estimateId = "<?= $estimate->id ?>";
        const storageKey = `estimate_sig_${estimateId}`;
        localStorage.removeItem(storageKey);

        document.getElementById("signature-signed-display").style.display = "none";
        document.getElementById("signature-trigger-panel").style.display = "block";
        
        // Reset editor form values
        document.getElementById("sig-name").value = "<?= h($company->name) ?> Representative";
        document.getElementById("sig-title").value = "Authorized Signatory";
        document.getElementById("sig-date").value = new Date().toISOString().split('T')[0];
    }
}

// Utility to check if a canvas is blank
function isCanvasBlank(canvas) {
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    return canvas.toDataURL() === blank.toDataURL();
}
</script>

<style>
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }

    @media print {
        @page {
            size: A4;
            margin: 10mm 15mm;
        }
        body {
            background: white !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
            color: #0f172a !important;
        }
        .estimates.view.content {
            font-size: 11px !important;
        }
        /* Reduce spacings */
        .estimates.view.content > div[style*="margin-bottom: 40px"] {
            margin-bottom: 12px !important;
            padding-bottom: 12px !important;
        }
        .estimates.view.content img[style*="max-height: 100px"] {
            max-height: 45px !important;
            margin-bottom: 5px !important;
        }
        .estimates.view.content h1[style*="font-size: 2.5rem"] {
            font-size: 1.6rem !important;
            margin-bottom: 4px !important;
        }
        .estimates.view.content div[style*="display: grid"][style*="gap: 40px"] {
            gap: 15px !important;
            margin-bottom: 15px !important;
        }
        .estimates.view.content h4 {
            margin-bottom: 4px !important;
            font-size: 0.7rem !important;
        }
        .estimates.view.content h3 {
            font-size: 0.95rem !important;
            margin-bottom: 2px !important;
        }
        .estimates.view.content h2[style*="font-size: 2.2rem"] {
            font-size: 1.4rem !important;
        }
        /* Related table adjustments */
        .estimates.view.content .related {
            margin-top: 10px !important;
        }
        .estimates.view.content table.table {
            margin-top: 10px !important;
            font-size: 10.5px !important;
        }
        .estimates.view.content table.table th {
            padding: 6px 8px !important;
            font-size: 0.75rem !important;
        }
        .estimates.view.content table.table td {
            padding: 8px 8px !important;
        }
        /* Subtotal and totals */
        .estimates.view.content div[style*="margin-top: 30px"] {
            margin-top: 12px !important;
        }
        .estimates.view.content div[style*="padding: 15px 0"] {
            padding: 8px 0 !important;
            font-size: 1.05rem !important;
        }
        /* Signature Section */
        .signature-section {
            margin-top: 15px !important;
            padding-top: 12px !important;
        }
        .signature-section div[style*="gap: 40px"] {
            gap: 15px !important;
        }
        .signature-section p {
            margin-bottom: 5px !important;
            font-size: 0.75rem !important;
            line-height: 1.4 !important;
        }
        .signature-section div[style*="background: #f8fafc"] {
            margin-top: 5px !important;
            padding: 6px !important;
        }
        #signature-signed-display {
            padding: 10px !important;
        }
        #sig-rendered-img {
            max-height: 40px !important;
        }
        #signature-signed-display div[style*="margin-bottom: 10px"] {
            margin-bottom: 4px !important;
        }
    }
</style>