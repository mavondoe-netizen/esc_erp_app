<?php
/**
 * Schema update for Parent Portal
 */
$host = 'localhost';
$db   = 'eras_app';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "Adding 'guardian_user_id' to 'sch_students' table...\n";
    $pdo->exec("ALTER TABLE sch_students ADD COLUMN guardian_user_id INT DEFAULT NULL AFTER user_id");
    
    echo "Done.\n";
    
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
