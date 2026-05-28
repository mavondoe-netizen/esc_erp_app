<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$cols = $pdo->query("DESCRIBE receipts")->fetchAll(PDO::FETCH_ASSOC);
echo "=== RECEIPTS COLUMNS ===\n";
foreach ($cols as $c) {
    echo sprintf("%-25s %-20s %-5s %-10s %s\n", $c['Field'], $c['Type'], $c['Null'], $c['Default'] ?? 'NULL', $c['Extra']);
}
