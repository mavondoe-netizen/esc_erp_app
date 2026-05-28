<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "=== RECEIPT/TRANSACTION/PAYMENT TABLES ===\n";
foreach ($tables as $t) {
    if (stripos($t, 'receipt') !== false || stripos($t, 'transaction') !== false || stripos($t, 'payment') !== false) {
        echo $t . "\n";
    }
}

echo "\n=== RECEIPTS SCHEMA ===\n";
try {
    $cols = $pdo->query("DESCRIBE receipts")->fetchAll(PDO::FETCH_ASSOC);
    print_r($cols);
} catch (Exception $e) {
    echo "No receipts table: " . $e->getMessage() . "\n";
}

echo "\n=== TRANSACTIONS SCHEMA ===\n";
try {
    $cols = $pdo->query("DESCRIBE transactions")->fetchAll(PDO::FETCH_ASSOC);
    print_r($cols);
} catch (Exception $e) {
    echo "No transactions table: " . $e->getMessage() . "\n";
}

echo "\n=== RECEIPT_ITEMS SCHEMA ===\n";
try {
    $cols = $pdo->query("DESCRIBE receipt_items")->fetchAll(PDO::FETCH_ASSOC);
    print_r($cols);
} catch (Exception $e) {
    echo "No receipt_items table: " . $e->getMessage() . "\n";
}

echo "\n=== RECEIPT_INVOICES SCHEMA ===\n";
try {
    $cols = $pdo->query("DESCRIBE receipt_invoices")->fetchAll(PDO::FETCH_ASSOC);
    print_r($cols);
} catch (Exception $e) {
    echo "No receipt_invoices table\n";
}

echo "\n=== SAMPLE RECEIPTS DATA ===\n";
try {
    $data = $pdo->query("SELECT * FROM receipts LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
    print_r($data);
} catch (Exception $e) {
    echo "None\n";
}

echo "\n=== SAMPLE TRANSACTIONS DATA ===\n";
try {
    $data = $pdo->query("SELECT * FROM transactions LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    print_r($data);
} catch (Exception $e) {
    echo "None\n";
}
