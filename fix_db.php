<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$pdo->exec('ALTER TABLE receipts MODIFY COLUMN supplier_id int(11) DEFAULT NULL');
echo 'receipts.supplier_id -> nullable OK' . PHP_EOL;
