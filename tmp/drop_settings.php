<?php
$db = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$db->exec('DROP TABLE IF EXISTS settings');
$db->exec('DELETE FROM phinxlog WHERE version = 20260312200000');
echo "Dropped settings table and cleaned phinxlog\n";
