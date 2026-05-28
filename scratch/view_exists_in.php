<?php
$existsInPath = 'vendor/cakephp/cakephp/src/ORM/Rule/ExistsIn.php';
if (file_exists($existsInPath)) {
    echo file_get_contents($existsInPath);
} else {
    echo "File not found: " . $existsInPath;
}
