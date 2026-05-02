<?php
/**
 * Schema fix script for MySQL
 */
$host = 'localhost';
$db   = 'eras_app';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "Checking 'payments' table columns...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM payments");
    $columns = $stmt->fetchAll();
    
    $hasSupplierId = false;
    $hasManualReference = false;
    
    foreach ($columns as $col) {
        if ($col['Field'] === 'supplier_id') $hasSupplierId = true;
        if ($col['Field'] === 'manual_reference') $hasManualReference = true;
    }
    
    if (!$hasSupplierId) {
        echo "Adding 'supplier_id' column to 'payments' table...\n";
        $pdo->exec("ALTER TABLE payments ADD COLUMN supplier_id INT DEFAULT NULL AFTER customer_id");
    } else {
        echo "'supplier_id' already exists.\n";
    }
    
    if (!$hasManualReference) {
        echo "Adding 'manual_reference' column to 'payments' table...\n";
        $pdo->exec("ALTER TABLE payments ADD COLUMN manual_reference VARCHAR(100) DEFAULT NULL");
    } else {
        echo "'manual_reference' already exists.\n";
    }
    
    // Also check 'receipts' table
    echo "Checking 'receipts' table columns...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM receipts");
    $columns = $stmt->fetchAll();
    
    $hasManualRefReceipt = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'manual_reference') $hasManualRefReceipt = true;
    }
    
    if (!$hasManualRefReceipt) {
        echo "Adding 'manual_reference' column to 'receipts' table...\n";
        $pdo->exec("ALTER TABLE receipts ADD COLUMN manual_reference VARCHAR(100) DEFAULT NULL");
    } else {
        echo "'manual_reference' already exists in 'receipts'.\n";
    }
    
    echo "Done.\n";
    
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
