<?php
$content = file_get_contents('templates/Invoices/view.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (strpos($line, 'Ref') !== false || strpos($line, 'ref') !== false || strpos($line, 'Invoice #') !== false) {
        echo "Line " . ($i + 1) . ": " . trim($line) . "\n";
    }
}
