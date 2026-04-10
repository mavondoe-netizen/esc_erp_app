<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$res = $pdo->query('SELECT model FROM permissions LIMIT 10')->fetchAll(PDO::FETCH_COLUMN);
echo implode(', ', $res);
