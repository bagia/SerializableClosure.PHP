<?php

// This file is meant to be run from the Command-Line

require_once("../src/SerializableClosure.php");

$foo = "bar";

echo "PHP Closure:\n";
$php_closure = function ($name, $platform) use ($foo) {
    echo "Hello {$name} on {$platform}\n";
    echo "Foo = {$foo}\n";
};
$php_closure('bagia', 'github');

echo "Serializable Closure:\n";
$closure = new SerializableClosure(function($name, $platform) use ($foo) {
    echo "Hello {$name} on {$platform}\n";
    echo "Foo = {$foo}\n";
});

$closure('bagia', 'github');

$s = serialize($closure);
$c = unserialize($s);
$c('bagia', 'unserialized closure');

echo "\n\n";

echo "PHP Closure:\n";
$php_closures = array();
for($i = 0; $i < 5; $i++) {
    $php_closures[] = function () use ($i) { echo "Hello world {$i}\n"; };
}
unset($i);
foreach($php_closures as $php_closure) {
    $php_closure();
}

echo "Serializable Closure:\n";
$closures = array();
for($i = 0; $i < 5; $i++) {
    $closures[] = serialize(new SerializableClosure(function () use ($i) { echo "Hello world {$i}\n"; }));
}
unset($i);
foreach($closures as $closure) {
    $closure = unserialize($closure);
    $closure();
}

echo "\n\n";

echo "Weird case, correct indentation:\n";
$test = function ($closure) {
    /*$closure = new SerializableClosure($closure);
    $closure = serialize($closure);
    $closure = unserialize($closure);*/
    $closure();
};
$test(function () use ($foo) {
    $closure = function() use ($foo) { echo "Hello {$foo}\n"; };
    $closure = new SerializableClosure($closure);
    $closure = serialize($closure);
    $closure = unserialize($closure); $closure();
});

echo "Weird case, wrong indentation:\n";
$test = function ($closure) { /*$closure = new SerializableClosure($closure); $closure = serialize($closure); $closure = unserialize($closure);*/ $closure(); };
$test(function () use ($foo) { $closure = function() use ($foo) { echo "Hello {$foo}\n"; }; $closure = new SerializableClosure($closure); $closure = serialize($closure); $closure = unserialize($closure); $closure(); });

echo "\n\n";
