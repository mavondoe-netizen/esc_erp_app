<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$estimates = $pdo->query("SELECT * FROM estimates LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
echo "### ESTIMATES:\n";
print_r($estimates);

$items = $pdo->query("SELECT * FROM estimate_items LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
echo "### ESTIMATE ITEMS:\n";
print_r($items);
