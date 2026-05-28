<?php
$dir = new RecursiveDirectoryIterator('templates/layout');
foreach (new RecursiveIteratorIterator($dir) as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'postLink') !== false) {
            echo "Found in: " . $file->getPathname() . "\n";
            // Print matching lines
            $lines = explode("\n", $content);
            foreach ($lines as $i => $line) {
                if (strpos($line, 'postLink') !== false) {
                    echo "  Line " . ($i + 1) . ": " . trim($line) . "\n";
                }
            }
        }
    }
}
