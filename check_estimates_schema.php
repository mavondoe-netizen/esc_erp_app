<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$columns = $pdo->query("DESCRIBE estimates")->fetchAll(PDO::FETCH_ASSOC);
echo "### ESTIMATES COLUMNS:\n";
print_r($columns);
