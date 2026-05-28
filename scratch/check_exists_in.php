<?php
require 'vendor/autoload.php';
$existsIn = new \Cake\ORM\Rule\ExistsIn(['product_id'], 'Products');
$ref = new ReflectionClass($existsIn);
echo "Properties:\n";
foreach ($ref->getProperties() as $p) {
    echo "  " . $p->getName() . "\n";
}
echo "Constructor parameters:\n";
$ctor = $ref->getConstructor();
foreach ($ctor->getParameters() as $param) {
    echo "  " . $param->getName() . "\n";
}
// Dump default options if any
$optionsProp = $ref->getProperty('_options');
$optionsProp->setAccessible(true);
echo "Default Options:\n";
print_r($optionsProp->getValue($existsIn));
