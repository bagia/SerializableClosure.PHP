<?php

// This file is meant to be run from the Command-Line

require_once("../src/SerializableClosure.php");

$foo = "bar";

echo "PHP Closure:\n";
$php_closure = function($name, $platform) use ($foo) {
    echo "Hello {$name} on {$platform}\n";
    echo "Foo = {$foo}\n";
};
$php_closure('bagia', 'github');

echo "\n\n";

echo "Serializable Closure:\n";
$closure = new SerializableClosure(function($name, $platform) use ($foo) {
    echo "Hello {$name} on {$platform}\n";
    echo "Foo = {$foo}\n";
});

$closure('bagia', 'github');

$s = serialize($closure);
$c = unserialize($s);
$c('bagia', 'unserialized closure');

