<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$products = $pdo->query("SELECT id, company_id, name, account_id FROM products LIMIT 50")->fetchAll(PDO::FETCH_ASSOC);
echo "### PRODUCTS:\n";
print_r($products);
