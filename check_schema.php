<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');

foreach (['estimates','estimate_items','receipts','invoices'] as $tbl) {
    echo "\n=== $tbl ===\n";
    foreach($pdo->query("DESCRIBE $tbl")->fetchAll(PDO::FETCH_ASSOC) as $c) {
        echo sprintf("%-25s %-20s %-5s %s\n", $c['Field'], $c['Type'], $c['Null'], $c['Key']);
    }
}

echo "\n=== Sample estimates (last 3) ===\n";
foreach($pdo->query("SELECT id,customer_id,status,total,date FROM estimates ORDER BY id DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo json_encode($r)."\n";
}

echo "\n=== Sample estimate_items (last 5) ===\n";
foreach($pdo->query("SELECT id,estimate_id,product_id,account_id,quantity,unit_price,line_total FROM estimate_items ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo json_encode($r)."\n";
}
