<?php
$log = date('Y-m-d H:i:s') . "\n";
$log .= "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
$log .= "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
$log .= "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
file_put_contents(__DIR__ . '/test_log.txt', $log, FILE_APPEND);
require 'index.php';
