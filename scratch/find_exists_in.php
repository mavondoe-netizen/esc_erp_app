<?php
foreach(glob('src/Model/Table/*.php') as $f) {
    $c = file_get_contents($f);
    if (strpos($c, 'existsIn') !== false) {
        preg_match_all('/existsIn.*/', $c, $m);
        if (!empty($m[0])) {
            echo basename($f) . ":\n";
            foreach ($m[0] as $line) {
                echo "  " . trim($line) . "\n";
            }
        }
    }
}
