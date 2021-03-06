SerializableClosure.PHP
=======================

A class to store and export/import closures in PHP.

Example
=======
```php
$foo = "bar";

$closure = new SerializableClosure(function($name, $platform) use ($foo) {
    echo "Hello {$name} on {$platform}\n";
    echo "Foo = {$foo}\n";
});

$closure('bagia', 'github');

$str = serialize($closure);
$c = unserialize($str);
$c('bagia', 'unserialized closure');
```

Known limitations
=================
Nested closures should not be created inline:
```php
// Will make your code unstable !!!
$closure = function() { $inner_closure = function () { echo "Hello world";} $s = new SerializableClosure($inner_closure); ... };
```

Do:
```php
// Must work:
$closure = function() {
    $inner_closure = function () { echo "Hello world"; }
    $s = new SerializableClosure($inner_closure);
... };
```

Prerequisites
=============
- PHP 5.3+
- eval() function not disabled

Inspired by
===========
The code is inspired by the article [Extending PHP 5.3 Closures with Serialization and Reflection](http://www.htmlist.com/development/extending-php-5-3-closures-with-serialization-and-reflection/) by Jeremy Lindblom, though all the code was re-impleted.

Concerns
========
I haven't tried using static variables in the test closures, so I don't know how the code will behave.

License
=======
This software is released under the MIT license.
