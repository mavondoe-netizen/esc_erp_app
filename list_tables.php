<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $t) {
    echo "$t\n";
}
