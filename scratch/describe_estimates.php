<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
foreach(['estimates', 'estimate_items'] as $t) {
    try {
        $cols = $pdo->query("DESCRIBE `$t`")->fetchAll(PDO::FETCH_ASSOC);
        echo "Table: $t\n";
        foreach ($cols as $col) {
            echo "  {$col['Field']} - {$col['Type']} - Null: {$col['Null']} - Key: {$col['Key']} - Default: {$col['Default']}\n";
        }
    } catch (Exception $e) {
        echo "$t: ERROR " . $e->getMessage() . "\n";
    }
}
