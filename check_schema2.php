<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');

// Check supplier_id constraint on receipts
$rows = $pdo->query("SHOW CREATE TABLE receipts")->fetch(PDO::FETCH_NUM);
echo $rows[1] . "\n\n";

// Check if any receipts have null supplier_id
$count = $pdo->query("SELECT COUNT(*) as cnt FROM receipts WHERE supplier_id IS NULL OR supplier_id = 0")->fetch(PDO::FETCH_ASSOC);
echo "Receipts with null/0 supplier_id: " . $count['cnt'] . "\n";

// Check invoices that have receipts
$invWithReceipts = $pdo->query("SELECT r.invoice_id, i.total, SUM(r.amount) as paid FROM receipts r JOIN invoices i ON i.id = r.invoice_id WHERE r.invoice_id IS NOT NULL GROUP BY r.invoice_id")->fetchAll(PDO::FETCH_ASSOC);
echo "\nInvoices with receipts:\n";
foreach ($invWithReceipts as $r) echo json_encode($r) . "\n";

// Check invoice_items columns
echo "\n=== invoice_items ===\n";
foreach($pdo->query("DESCRIBE invoice_items")->fetchAll(PDO::FETCH_ASSOC) as $c) {
    echo sprintf("%-25s %-20s %-5s %s\n", $c['Field'], $c['Type'], $c['Null'], $c['Key']);
}
