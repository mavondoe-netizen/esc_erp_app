<?php
/**
 * Document Layout for Invoices, Receipts, etc.
 * Provides a clean, centered view without main navigation.
 */
$cakeDescription = 'ESCerp App - Premium Document';
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
    <?= $this->Html->css(['premium']) ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <style>
        :root {
            --primary-color: #2563eb;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
        }
        body { 
            background: var(--bg-color); 
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .document-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }
        .document-container { 
            width: 100%;
            max-width: 850px; 
            background: var(--card-bg); 
            padding: 50px; 
            border-radius: 16px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.05); 
            position: relative;
            border: 1px solid #e2e8f0;
        }
        .document-actions {
            width: 100%;
            max-width: 850px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-doc {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-print { background: #1e293b; color: white; }
        .btn-print:hover { background: #0f172a; transform: translateY(-1px); }
        .btn-back { background: #e2e8f0; color: #475569; }
        .btn-back:hover { background: #cbd5e1; }
        
        .btn-success { background: #16a34a; color: white; }
        .btn-success:hover { background: #15803d; transform: translateY(-1px); }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-warning:hover { background: #d97706; transform: translateY(-1px); }
        .btn-info { background: #0ea5e9; color: white; }
        .btn-info:hover { background: #0284c7; transform: translateY(-1px); }
        
        @media print {
            body { background: white; }
            .document-wrapper { padding: 0; display: block; }
            .document-container { 
                margin: 0; 
                padding: 0; 
                box-shadow: none !important; 
                max-width: 100% !important; 
                border-radius: 0 !important; 
                border: none !important;
            }
            .no-print { display: none !important; }
        }
        
        /* Premium Typography & Spacing */
        h1, h2, h3 { color: #0f172a; margin-top: 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .table th { text-align: left; padding: 12px; border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .table td { padding: 16px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
    </style>
</head>
<body>
    <div class="document-wrapper">
        <div class="document-actions no-print">
            <div>
                 <a href="<?= $this->Url->build('/') ?>" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 1.2rem;">
                    <i class="fa fa-th-large"></i> ESCerp
                 </a>
            </div>
            <div style="display: flex; gap: 12px;">
                <?= $this->fetch('actions') ?>
                <button onclick="window.print()" class="btn-doc btn-print"><i class="fa fa-print"></i> Print</button>
                <button onclick="window.history.back()" class="btn-doc btn-back"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
        </div>
        
        <div class="document-container">
            <?= $this->fetch('content') ?>
        </div>
        
        <div class="no-print" style="margin-top: 40px; color: #94a3b8; font-size: 0.85rem;">
            &copy; <?= date('Y') ?> <?= h($cakeDescription) ?> — Generated securely for your records.
        </div>
    </div>
    
    <?= $this->fetch('script') ?>
</body>
</html>
