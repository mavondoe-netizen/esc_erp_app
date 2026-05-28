<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$columns = $pdo->query("DESCRIBE invoice_items")->fetchAll(PDO::FETCH_ASSOC);
echo "### INVOICE ITEMS COLUMNS:\n";
print_r($columns);
