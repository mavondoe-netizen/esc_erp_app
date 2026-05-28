<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$columns = $pdo->query("DESCRIBE invoices")->fetchAll(PDO::FETCH_ASSOC);
echo "### INVOICES COLUMNS:\n";
print_r($columns);
